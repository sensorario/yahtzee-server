<?php

namespace App\Tests\Yahtzee;

use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use App\Yahtzee\Turns;
use App\Yatzee\Category;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    /** @test  */
    public function playACompleteGame(): void
    {
        $turns = new Turns;
        $turns->record(new Move(Categories::Yahtzee, [1, 1, 1, 1, 1]));
        $turns->record(new Move(Categories::Chance, [1, 1, 1, 1, 1]));
        $this->assertEquals(55, $turns->score());
    }
}