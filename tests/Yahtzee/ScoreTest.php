<?php

namespace App\Tests\Yahtzee;

use App\Yahtzee\Categories;
use App\Yahtzee\Score;
use PHPUnit\Framework\TestCase;

class ScoreTest extends TestCase
{
    /** @dataProvider provider */
    public function testSomething($dices, $cat, $expectedAmount): void
    {
        $score = new Score($dices, $cat);
        $this->assertEquals($expectedAmount, $score->amount());
    }

    public function provider()
    {
        return [
            [[1, 1, 1, 1, 1], Categories::Aces, 5],
            [[1, 3, 1, 1, 1], Categories::Aces, 4],
            [[1, 3, 1, 1, 1], Categories::Twos, 0],
            [[1, 2, 1, 2, 1], Categories::Twos, 4],
            [[1, 3, 1, 1, 1], Categories::Threes, 3],
            [[1, 2, 1, 2, 1], Categories::Threes, 0],
            [[1, 3, 1, 1, 1], Categories::Fours, 0],
            [[1, 2, 1, 4, 1], Categories::Fours, 4],
            [[1, 3, 1, 1, 1], Categories::Fives, 0],
            [[1, 2, 5, 4, 5], Categories::Fives, 10],
            [[1, 3, 1, 1, 1], Categories::Sixs, 0],
            [[6, 6, 6, 6, 6], Categories::Sixs, 30],
            
            [[6, 6, 6, 6, 6], Categories::ThreOfAType, 30],
            [[6, 6, 1, 1, 1], Categories::ThreOfAType, 15],
            [[6, 6, 1, 3, 1], Categories::ThreOfAType, 0],
            [[6, 6, 6, 6, 6], Categories::FourOfAType, 30],
            [[1, 6, 1, 1, 1], Categories::FourOfAType, 10],
            [[1, 6, 1, 3, 1], Categories::FourOfAType, 0],
            [[6, 6, 1, 1, 1], Categories::Chance, 15],

            [[6, 6, 1, 1, 1], Categories::Yahtzee, 0],
            [[1, 1, 1, 1, 1], Categories::Yahtzee, 50],
            [[1, 1, 1, 1, 1], Categories::FullHouse, 0],
            [[1, 3, 3, 1, 1], Categories::FullHouse, 25],

            [[1, 2, 3, 4, 1], Categories::SmallStraight, 30],
            [[5, 2, 3, 4, 1], Categories::SmallStraight, 30],
            [[5, 2, 3, 4, 6], Categories::SmallStraight, 30],
            [[1, 2, 3, 1, 6], Categories::SmallStraight, 0],

            [[5, 2, 3, 4, 1], Categories::LargeStraight, 40],
            [[5, 2, 3, 4, 6], Categories::LargeStraight, 40],
            [[1, 2, 3, 1, 6], Categories::LargeStraight, 0],
        ];
    }
}
