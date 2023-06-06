<?php

namespace App\Tests\Yahtzee;

use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use App\Yahtzee\Turns;
use App\Yatzee\Category;
use PHPUnit\Framework\TestCase;

class TurnsTest extends TestCase
{
    /** @test  */
    public function areGloballyThirteen(): void
    {
        $turns = new Turns;
        $this->assertEquals(13, $turns->availableMoves());
    }

    /** @test  */
    public function afterEachMoveDecreaseNumberOfAvailableMoves(): void
    {
        $move = $this->getMockBuilder(Move::class)
            ->disableOriginalConstructor()
            ->getMock();

        $turns = new Turns;
        $turns->record($move);
        $this->assertEquals(12, $turns->availableMoves());
    }

    /** @test  */
    public function throwAnExceptionWheneverSameCategoryIsUsedTwice(): void
    {
        $this->expectException(\RuntimeException::class);

        $move = $this->getMockBuilder(Move::class)
            ->disableOriginalConstructor()
            ->getMock();
        $move->method('getCategory')
            ->willReturnOnConsecutiveCalls(Categories::Fives->value, Categories::Fives->value);

        $turns = new Turns;
        $turns->record($move);
        $turns->record($move);
    }
}
