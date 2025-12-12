<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\GridHelper;
use App\Solutions\Support\Helpers\InputParser;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::grid($this->input);

        $directions = GridHelper::allNeighbors(0, 0);

        $xPositions = GridHelper::findAll($input, 'X');

        $xmasCount = 0;
        foreach ($xPositions as $xPosition) {
            foreach ($directions as $direction) {
                $x = $xPosition[0];
                $y = $xPosition[1];

                $word = 'X';
                for ($i = 0; $i < 3; $i++) {
                    $x += $direction[0];
                    $y += $direction[1];

                    if (GridHelper::inBounds($input, $x, $y)) {
                        $word .= $input[$x][$y];
                    }
                }

                if ($word == 'XMAS') {
                    $xmasCount++;
                }
            }
        }

        return $xmasCount;
    }

    /**
     * Day 04 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::grid($this->input);

        $aPositions = GridHelper::findAll($input, 'A');

        $xmasCount = 0;
        foreach ($aPositions as $aPosition) {
            $x = $aPosition[0];
            $y = $aPosition[1];

            if (GridHelper::inBounds($input, $x - 1, $y - 1)
                && GridHelper::inBounds($input, $x + 1, $y + 1)
            ) {
                $a = $input[$x - 1][$y - 1]
                    . $input[$x][$y]
                    . $input[$x + 1][$y + 1];

                $b = $input[$x - 1][$y + 1]
                    . $input[$x][$y]
                    . $input[$x + 1][$y - 1];

                if (
                    ($a == 'MAS' || strrev($a) == 'MAS')
                    && ($b == 'MAS' || strrev($b) == 'MAS')
                ) {
                    $xmasCount++;
                }
            }
        }

        return $xmasCount;
    }
}
