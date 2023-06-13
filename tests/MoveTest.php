<?php

namespace App\Tests;

use App\Yahtzee\Categories;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoveTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('POST', '/move', [], [], [], json_encode([
            'dices' => [1, 1, 2, 3, 1],
            'category' => Categories::Aces->value,
        ]));

        $this->assertJsonStringEqualsJsonString(json_encode(['score' => 3]), $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }
}
