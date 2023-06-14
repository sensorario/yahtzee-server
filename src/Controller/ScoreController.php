<?php

namespace App\Controller;

use App\Repository\MoveRepository;
use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use App\Yahtzee\Turns;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    #[Route('/score/{gameId}', name: 'app_score')]
    public function index(
        string $gameId,
        MoveRepository $moveRepository,
    ): Response {
        $moves = $moveRepository->findBy([
            'game' => $gameId,
        ]);

        $score = 0;
        $turns = new Turns;
        foreach ($moves as $move) {
            $turns->record(new Move(Categories::from($move->getCategory()), $move->getDices()));
            $score = $turns->score();
        }

        return $this->json([
            'score' => $score,
        ]);
    }
}
