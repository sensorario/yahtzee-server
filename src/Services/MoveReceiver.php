<?php

namespace App\Services;

use App\Repository\MoveRepository;
use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use App\Yahtzee\Turns;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MoveReceiver
{
    public function __construct(
        private Turns $turns,
        private MoveRepository $repo,
    ) { }

    public function consumeRequest(array $decoded): Turns
    {
        // loadHistory
        $move = new Move(Categories::from($decoded['category']), $decoded['dices']);
        
        // turns record move
        $this->turns->record($move);

        return $this->turns;
    }
}