<?php

namespace App\Solutions\Year2020;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day05 extends Solution
{
    /**
     * Day 05 Part 1
     */
    public function partOne(): string|int|null
    {
        $passes = array_map(fn ($pass) => str_split($pass), InputParser::lines($this->input));

        $max = 0;
        foreach ($passes as $pass) {
            $row = range(0, 127);
            $col = range(0, 7);

            foreach ($pass as $split) {
                if ($split == 'F' || $split == 'B') {
                    $row = match ($split) {
                        'B' => array_slice($row, intval(count($row) / 2)),
                        'F' => array_slice($row, 0, intval(count($row) / 2)),
                    };
                }

                if ($split == 'L' || $split == 'R') {
                    $col = match ($split) {
                        'R' => array_slice($col, intval(count($col) / 2)),
                        'L' => array_slice($col, 0, intval(count($col) / 2)),
                    };
                }
            }

            $max = max($max, $row[0] * 8 + $col[0]);
        }

        return $max;
    }

    /**
     * Day 05 Part 2
     */
    public function partTwo(): string|int|null
    {
        $passes = array_map(fn ($pass) => str_split($pass), InputParser::lines($this->input));

        $seatIds = [];
        foreach ($passes as $pass) {
            $row = range(0, 127);
            $col = range(0, 7);

            foreach ($pass as $split) {
                if ($split == 'F' || $split == 'B') {
                    $row = match ($split) {
                        'B' => array_slice($row, intval(count($row) / 2)),
                        'F' => array_slice($row, 0, intval(count($row) / 2)),
                    };
                }

                if ($split == 'L' || $split == 'R') {
                    $col = match ($split) {
                        'R' => array_slice($col, intval(count($col) / 2)),
                        'L' => array_slice($col, 0, intval(count($col) / 2)),
                    };
                }
            }

            $seatIds[] = $row[0] * 8 + $col[0];
        }
        sort($seatIds);

        $flipped = array_flip($seatIds);

        for ($i = min($seatIds) + 1; $i <= max($seatIds) - 1; $i++) {
            if (
                !array_key_exists($i, $flipped)
                && array_key_exists($i - 1, $flipped)
                && array_key_exists($i + 1, $flipped)) {
                return $i;
            }
        }

        return null;
    }
}
