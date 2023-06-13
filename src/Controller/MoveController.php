<?php

namespace App\Controller;

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
    public function index(Request $request, MoveReceiver $moveReceiver): Response
    {
        $decoded = json_decode($request->getContent(), true);
        
        $turns = $moveReceiver->consumeRequest($decoded);

        return $this->json([
            'score' => $turns->score(),
        ]);
    }
}
