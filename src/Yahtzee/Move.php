<?php

namespace App\Yahtzee;

class Move
{
    public function __construct(
        private Categories $categories,
        private array $dices,
    ) {
    }
        
    public function getCategory(): int
    {
        return $this->categories->value;
    }

    public function score(): int
    {
        $score = new Score($this->dices, $this->categories);
        return $score->amount();
    }
}