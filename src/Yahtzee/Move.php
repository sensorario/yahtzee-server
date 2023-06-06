<?php

namespace App\Yahtzee;

class Move
{
    public function getCategory(): int
    {
        return Categories::Aces->value;
    }
}