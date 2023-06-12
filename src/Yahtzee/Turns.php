<?php

namespace App\Yahtzee;

class Turns
{
    private array $moves = [];
    public function availableMoves()
    {
        return 13 - count($this->moves);
    }
    
    public function record(Move $move)
    {
        $key = $move->getCategory();

        if (isset($this->moves[$key])) {
            throw new \RuntimeException;
        }

        $this->moves[$key] = $move;
    }

    public function score()
    {
        $score = 0;
        foreach($this->moves as $move) {
            $score += $move->score();
        }
        return $score;
    }
}