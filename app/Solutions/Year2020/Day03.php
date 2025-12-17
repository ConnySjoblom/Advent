<?php

namespace App\Solutions\Year2020;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::grid($this->input);

        $map = [];
        $repeat = count($input) * 3 / count($input[0]);
        foreach ($input as $y => $line) {
            for ($i = 0; $i < count($line) * $repeat; $i++) {
                $map[$y][] = $line[$i % count($line)];
            }
        }

        $trees = $x = $y = 0;
        while ($y < count($map) && $x < count($map[0])) {
            if ($map[$y][$x] == '#') {
                $map[$y][$x] = 'X';
                $trees++;
            } else {
                $map[$y][$x] = 'O';
            }

            $x += 3;
            $y += 1;
        }

        return $trees;
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::grid($this->input);

        $answer = 1;
        $slopes = [[1, 1], [3, 1], [5, 1], [7, 1], [1, 2]];
        foreach ($slopes as $slope) {
            $map = [];
            $repeat = count($input) * $slope[0] / count($input[0]);
            foreach ($input as $y => $line) {
                for ($i = 0; $i < count($line) * $repeat; $i++) {
                    $map[$y][] = $line[$i % count($line)];
                }
            }

            $trees = $x = $y = 0;
            while ($y < count($map) && $x < count($map[0])) {
                if ($map[$y][$x] == '#') {
                    $map[$y][$x] = 'X';
                    $trees++;
                } else {
                    $map[$y][$x] = 'O';
                }

                $x += $slope[0];
                $y += $slope[1];
            }

            $answer *= $trees;
        }

        return $answer;
    }
}
