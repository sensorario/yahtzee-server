<?php

namespace App\Controller;

use App\Entity\Score;
use App\Services\MoveReceiver;
use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use App\Yahtzee\Turns;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoveController extends AbstractController
{
    #[Route('/move', name: 'app_move')]
    public function index(Request $request): Response
    {
        // calcolo punteggio
        $decoded = json_decode($request->getContent(), true);
        $move = new Move(Categories::from($decoded['category']), $decoded['dices']);
        $turns = new Turns;
        $turns->record($move);
        $score = $turns->score();

        return $this->json([
            'score' => $score,
        ]);
    }
}
