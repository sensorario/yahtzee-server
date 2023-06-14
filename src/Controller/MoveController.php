<?php

namespace App\Controller;

use App\Repository\MoveRepository;
use App\Services\MoveRequest;
use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use App\Yahtzee\Turns;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoveController extends AbstractController
{
    #[Route('/move', name: 'app_move')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        MoveRepository $moveRepository,
    ): Response {
        $decoded = json_decode($request->getContent(), true);

        if (!isset($decoded['game_id'])) {
            throw new BadRequestException('Oops! Missing game id');
        }

        $moves = $moveRepository->findBy([
            'game' => $decoded['game_id'],
        ]);

        $turns = new Turns;
        foreach ($moves as $move) {
            $turns->record(new Move(Categories::from($move->getCategory()), $move->getDices()));
        }
        
        // calcolo punteggio
        $move = new Move(Categories::from($decoded['category']), $decoded['dices']);

        try {
            $turns->record($move);
        } catch(\Exception $e) {
            throw new BadRequestException;
        }

        $score = $turns->score();

        // persisto punteggo
        $moveEntity = new \App\Entity\Move;
        $moveEntity->setGame($decoded['game_id']);
        $moveEntity->setDices($decoded['dices']);
        $moveEntity->setCategory($decoded['category']);
        $manager->persist($moveEntity);
        $manager->flush();

        return $this->json([
            'score' => $score,
        ]);
    }
}
