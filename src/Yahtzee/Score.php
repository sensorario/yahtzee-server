<?php

namespace App\Yahtzee;

use Symfony\Component\VarExporter\VarExporter;

class Score
{
    public function __construct(
        private array $dices,
        private Categories $categories,
    ) {}

    public function amount()
    {
        $valuesQuantity = array_count_values(array_values($this->dices));
        $flipped = array_flip($valuesQuantity);

        if ($this->categories === Categories::SmallStraight) {
            if (
                in_array(1, $this->dices)
                && in_array(2, $this->dices)
                && in_array(3, $this->dices)
                && in_array(4, $this->dices)
                ||
                in_array(2, $this->dices)
                && in_array(3, $this->dices)
                && in_array(4, $this->dices)
                && in_array(5, $this->dices)
                ||
                in_array(3, $this->dices)
                && in_array(4, $this->dices)
                && in_array(5, $this->dices)
                && in_array(6, $this->dices)
            ) {
                return 30;
            }
        }

        if ($this->categories === Categories::LargeStraight) {
            if (
                in_array(1, $this->dices)
                && in_array(2, $this->dices)
                && in_array(3, $this->dices)
                && in_array(4, $this->dices)
                && in_array(5, $this->dices)
                ||
                in_array(2, $this->dices)
                && in_array(3, $this->dices)
                && in_array(4, $this->dices)
                && in_array(5, $this->dices)
                && in_array(6, $this->dices)
            ) {
                return 40;
            }
        }

        if ($this->categories === Categories::Yahtzee) 
            if (isset($flipped[5]))
                return 50;

        if ($this->categories === Categories::ThreOfAType) 
            if (isset($flipped[3]) || isset($flipped[4]) || isset($flipped[5]))
                return array_sum($this->dices);

        if ($this->categories === Categories::FullHouse) 
            if (isset($flipped[3]) && isset($flipped[2]))
                return 25;

        if ($this->categories === Categories::FourOfAType)
            if (isset($flipped[4]) || isset($flipped[5]))
                return array_sum($this->dices);

        if ($this->categories === Categories::Chance)
                return array_sum($this->dices);

        $amount = 0;
        foreach($this->dices as $dice)
            if ($dice === $this->categories->value)
                $amount += $this->categories->value;

        return $amount;
    }
}