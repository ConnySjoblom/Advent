<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day10 extends Solution
{
    /**
     * Day 10 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::grid($this->input);

        $score = 0;
        $openChars = ['(','[', '{', '<'];
        foreach ($input as $line) {

            $stack = [];
            foreach ($line as $char) {
                if (in_array($char, $openChars)) {
                    $stack[] = $char;
                    continue;
                }

                if ($this->convertToOpeningChar($char) == end($stack)) {
                    array_pop($stack);
                } else {
                    $score += $this->scoreIllegalChar($char);
                    break;
                }
            }
        }

        return $score;
    }

    /**
     * Day 10 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::grid($this->input);

        $scores = [];
        $openChars = ['(','[', '{', '<'];
        foreach ($input as $line) {

            $stack = [];
            $corrupted = false;
            foreach ($line as $char) {
                if (in_array($char, $openChars)) {
                    $stack[] = $char;
                    continue;
                }

                if ($this->convertToOpeningChar($char) == end($stack)) {
                    array_pop($stack);
                } else {
                    $corrupted = true;
                    break;
                }
            }

            if (!$corrupted && count($stack) > 0) {
                $lineScore = 0;
                foreach (array_reverse($stack) as $char) {
                    $lineScore *= 5;
                    $lineScore += $this->scoreMissingChar($char);
                }
                $scores[] = $lineScore;
            }
        }

        sort($scores);
        return $scores[intdiv(count($scores), 2)];
    }

    public function convertToOpeningChar($char): string
    {
        return match ($char) {
            ')' => '(',
            ']' => '[',
            '}' => '{',
            '>' => '<',
            default => throw new \Exception("Invalid character '{$char}'"),
        };
    }

    public function scoreIllegalChar($char): int
    {
        return match ($char) {
            ')' => 3,
            ']' => 57,
            '}' => 1197,
            '>' => 25137,
            default => throw new \Exception("Invalid character '{$char}'"),
        };
    }

    public function scoreMissingChar($char): int
    {
        return match ($char) {
            '(' => 1,
            '[' => 2,
            '{' => 3,
            '<' => 4,
            default => throw new \Exception("Invalid character '{$char}'"),
        };
    }
}
