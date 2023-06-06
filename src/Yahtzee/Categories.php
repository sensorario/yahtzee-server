<?php

namespace App\Yahtzee;

enum Categories: int
{
    case Aces = 1;
    case Twos = 2;
    case Threes = 3;
    case Fours = 4;
    case Fives = 5;
    case Sixs = 6;
    case ThreOfAType = 7;
    case FourOfAType = 8;
    case SmallStraight = 9;
    case LargeStraight = 10;
    case FullHouse = 11;
    case Chance = 12;
    case Yahtzee = 13;
}