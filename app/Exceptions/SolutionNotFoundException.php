<?php

namespace App\Exceptions;

use App\Data\PuzzleIdentifier;
use Exception;

class SolutionNotFoundException extends Exception
{
    public static function forPuzzle(PuzzleIdentifier $puzzle): self
    {
        return new self(sprintf(
            'Solution for %d Day %02d not found',
            $puzzle->year,
            $puzzle->day,
        ));
    }
}
