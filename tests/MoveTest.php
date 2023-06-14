<?php

namespace App\Tests;

use App\Yahtzee\Categories;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoveTest extends WebTestCase
{
    public function testMoveReequestFailsWithoutGameId(): void
    {
        $client = static::createClient();
        $client->request('POST', '/move', [], [], [], json_encode([ 'dices' => [1, 1, 2, 3, 1], 'category' => Categories::Aces->value ]));
        $this->assertResponseStatusCodeSame(400);
    }

    public function testMoveRequestSucceedWothCompleteRequest(): void
    {
        $client = static::createClient();
        $client->request('POST', '/move', [], [], [], json_encode([ 'game_id' => rand(11111111, 99999999), 'dices' => [1, 1, 2, 3, 1], 'category' => Categories::Aces->value ]));
        $this->assertJsonStringEqualsJsonString(json_encode(['score' => 3]), $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }

    public function testScoreIsZeroWithoutMoves(): void
    {
        $client = static::createClient();
        $client->request('GET', '/score/42');
        $this->assertJsonStringEqualsJsonString(json_encode(['score' => 0]), $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }

    public function testScoreChangeAfterAMove(): void
    {
        $gameId = rand(11111111, 99999999);
        $client = static::createClient();
        $client->request('POST', '/move', [], [], [], json_encode([ 'game_id' => $gameId, 'dices' => [1, 1, 2, 3, 1], 'category' => Categories::Aces->value ]));
        $this->assertJsonStringEqualsJsonString(json_encode(['score' => 3]), $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/score' . '/' . $gameId);
        $this->assertJsonStringEqualsJsonString(json_encode(['score' => 3]), $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }
    public function testCantChoseSameCategoryTwice(): void
    {
        $gameId = rand(11111111, 99999999);
        $client = static::createClient();
        $client->request('POST', '/move', [], [], [], json_encode([ 'game_id' => $gameId, 'dices' => [1, 1, 2, 3, 1], 'category' => Categories::Aces->value ]));
        $client->request('POST', '/move', [], [], [], json_encode([ 'game_id' => $gameId, 'dices' => [1, 1, 2, 3, 1], 'category' => Categories::Aces->value ]));
        $this->assertResponseStatusCodeSame(400);
    }
    public function testTwoMovesIncremntScore(): void
    {
        $gameId = rand(11111111, 99999999);
        $client = static::createClient();
        $client->request('POST', '/move', [], [], [], json_encode([ 'game_id' => $gameId, 'dices' => [1, 1, 2, 3, 1], 'category' => Categories::Aces->value ]));

        $client->request('GET', '/score' . '/' . $gameId);
        $this->assertJsonStringEqualsJsonString(json_encode(['score' => 3]), $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();

        $client->request('POST', '/move', [], [], [], json_encode([ 'game_id' => $gameId, 'dices' => [1, 3, 3, 3, 1], 'category' => Categories::Threes->value]));
        $this->assertResponseStatusCodeSame(200);

        $client->request('GET', '/score' . '/' . $gameId);
        $this->assertJsonStringEqualsJsonString(json_encode(['score' => 12]), $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }
}
