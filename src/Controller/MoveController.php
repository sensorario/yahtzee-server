<?php

namespace App\Controller;

use App\Repository\MoveRepository;
use App\Request\MoveRequest;
use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use App\Yahtzee\Turns;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoveController extends AbstractController
{
    #[Route('/move', name: 'app_move')]
    public function index(
        EntityManagerInterface $manager,
        MoveRepository $moveRepository,
        MoveRequest $moveRequest,
    ): Response {
        if ($moveRequest->isMissingGameIdentifier()) {
            throw new BadRequestException('Oops! Missing game id');
        }

        $moves = $moveRepository->findBy([
            'game' => $moveRequest->getGameIdentifier(),
        ]);

        $turns = new Turns;
        foreach ($moves as $item) {
            $cat = Categories::from($item->getCategory());
            $dices = $item->getDices();
            $yahtzeeMove = new Move($cat, $dices);
            $turns->record($yahtzeeMove);
        }

        try {
            $move = $moveRequest->getYahtzeeMove();
            $turns->record($move);
        } catch(\Exception $e) {
            throw new BadRequestException;
        }

        // persisto punteggo
        $moveEntity = new \App\Entity\Move;
        $moveEntity->setGame($moveRequest->getGameIdentifier());
        $moveEntity->setDices($moveRequest->getDices());
        $moveEntity->setCategory($moveRequest->getCategory());
        $manager->persist($moveEntity);
        $manager->flush();
        
        return $this->json([
            'score' => $turns->score(),
        ], 200);
    }
}
