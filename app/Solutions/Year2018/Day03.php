<?php

namespace App\Solutions\Year2018;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::lines($this->input);

        $claims = [];
        foreach ($input as $claim) {
            preg_match("/#(\d*) @ (\d*),(\d*): (\d*)x(\d*)/", $claim, $matches);

            $id = intval($matches[1]);
            $position_x = intval($matches[2]);
            $position_y = intval($matches[3]);
            $width = intval($matches[4]);
            $height = intval($matches[5]);

            for ($x = $position_x; $x < $position_x + $width; $x++) {
                for ($y = $position_y; $y < $position_y + $height; $y++) {
                    $claims[$x][$y][] = $id;
                }
            }
        }

        $withinTwoOrMore = 0;
        foreach ($claims as $x) {
            foreach ($x as $y) {
                if (count($y) >= 2) {
                    $withinTwoOrMore++;
                }
            }
        }

        return $withinTwoOrMore;
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::lines($this->input);

        $ids = [];
        $claims = [];
        foreach ($input as $claim) {
            preg_match("/#(\d*) @ (\d*),(\d*): (\d*)x(\d*)/", $claim, $matches);

            $id = intval($matches[1]);
            $position_x = intval($matches[2]);
            $position_y = intval($matches[3]);
            $width = intval($matches[4]);
            $height = intval($matches[5]);

            $ids[] = $id;
            for ($x = $position_x; $x < $position_x + $width; $x++) {
                for ($y = $position_y; $y < $position_y + $height; $y++) {
                    $claims[$x][$y][] = $id;
                }
            }
        }

        foreach ($claims as $x) {
            foreach ($x as $y) {
                if (count($y) >= 2) {
                    foreach ($y as $id) {
                        $ids = array_diff($ids, [$id]);
                    }
                }
            }
        }

        return array_values($ids)[0];
    }
}
