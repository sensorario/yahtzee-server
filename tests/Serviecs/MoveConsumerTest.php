<?php

namespace App\Tests\Serviecs;

use App\Repository\MoveRepository;
use App\Services\MoveReceiver;
use App\Yahtzee\Categories;
use App\Yahtzee\Turns;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class MoveConsumerTest extends TestCase
{
    public function testSomething(): void
    {
        /** @var \App\Yahtzee\Turns $turns */
        $turns = $this->getMockBuilder(Turns::class)->getMock();
        
        /** @var \App\Repository\MoveRepository $turns */
        $em = $this->getMockBuilder(MoveRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $move = new MoveReceiver($turns, $em);
        $turns = $move->consumeRequest([
            'category' => Categories::Aces->value,
            'dices' => [1, 2, 3, 4, 5]
        ]);
        $this->assertEquals(3, $turns->score());
    }
}
