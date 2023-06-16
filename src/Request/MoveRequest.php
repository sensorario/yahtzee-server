<?php

namespace App\Request;

use App\Yahtzee\Categories;
use App\Yahtzee\Move;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MoveRequest
{
    private array $decoded;

    public function __construct(
        private RequestStack $requestStack,
    ) {
        $request = $this->requestStack->getCurrentRequest();
        $content = $request->getContent();
        $this->decoded = json_decode($content, true);
    }

    public function isMissingGameIdentifier()
    {
        if (!isset($this->decoded['game_id'])) {
            throw new BadRequestException('Oops! Missing game id');
        }
    }

    public function getGameIdentifier()
    {
        return $this->decoded['game_id'];
    }

    public function getDices()
    {
        return $this->decoded['dices'];
    }

    public function getCategory()
    {
        return $this->decoded['category'];
    }

    public function getYahtzeeMove(): Move
    {
        return new Move(
            Categories::from($this->getCategory()),
            $this->getDices(),
        );
    }
}