<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::groups($this->input);
        $numbers = explode(',', array_shift($input));

        $boards = [];
        foreach ($input as $b) {
            $boards[] = array_map(
                fn ($line) => preg_split('/\s+/', trim($line)),
                explode("\n", $b)
            );
        }

        for ($i = 0; $i < count($numbers); $i++) {
            $number = $numbers[$i];
            foreach ($boards as &$board) {
                for ($y = 0; $y < count($board); $y++) {
                    for ($x = 0; $x < count($board[$y]); $x++) {
                        if ($board[$y][$x] == $number) {
                            $board[$y][$x] = 'x';
                        }

                        if ($this->checkBoard($board, $x, $y)) {
                            return $this->calculateScore($board) * intval($number);
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * Day 04 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::groups($this->input);
        $numbers = explode(',', array_shift($input));

        $boards = [];
        $boardsWon = [];
        foreach ($input as $b) {
            $boards[] = array_map(
                fn ($line) => preg_split('/\s+/', trim($line)),
                explode("\n", $b)
            );
        }

        for ($i = 0; $i < count($numbers); $i++) {
            $number = $numbers[$i];
            foreach ($boards as $boardId => &$board) {
                for ($y = 0; $y < count($board); $y++) {
                    for ($x = 0; $x < count($board[$y]); $x++) {
                        if ($board[$y][$x] == $number) {
                            $board[$y][$x] = 'x';
                        }

                        if (
                            $this->checkBoard($board, $x, $y)
                            && !in_array($boardId, $boardsWon)
                        ) {
                            $boardsWon[] = $boardId;

                            if (count($boardsWon) == count($boards)) {
                                return $this->calculateScore($board) * intval($number);
                            }
                        }
                    }
                }
            }
        }

        return null;
    }

    private function checkBoard(array $board, $nx, $ny): bool
    {
        $my = $mx = 0;
        for ($y = 0; $y < count($board); $y++) {
            $my += $board[$y][$nx] == 'x' ? 1 : 0;
        }

        if ($my == count($board)) {
            return true;
        }

        for ($x = 0; $x < count($board[$ny]); $x++) {
            $mx += $board[$ny][$x] == 'x' ? 1 : 0;
        }

        if ($mx == count($board[$ny])) {
            return true;
        }

        return false;
    }

    private function calculateScore(mixed $board): int
    {
        $score = 0;
        for ($y = 0; $y < count($board); $y++) {
            for ($x = 0; $x < count($board[$y]); $x++) {
                $score += $board[$y][$x] != 'x' ? $board[$y][$x] : 0;
            }
        }

        return $score;
    }
}
