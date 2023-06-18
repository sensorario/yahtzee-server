<?php

namespace App\Tests\Yahtzee;

use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use PHPUnit\Framework\TestCase;

class MoveTest extends TestCase
{
    public function testSomething()
    {
        $move = new Move(Categories::Yahtzee, [1, 1, 1, 1, 1]);
        $this->assertEquals(50, $move->score());
    }
}