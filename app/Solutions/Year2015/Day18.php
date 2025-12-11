<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\GridHelper;
use App\Solutions\Support\Helpers\InputParser;

class Day18 extends Solution
{
    /**
     * Day 18 Part 1
     */
    public function partOne(int $steps = 100): string|int|null
    {
        $config = InputParser::grid($this->input);

        for ($i = 0; $i < $steps; $i++) {
            $newConfig = [];
            for ($x = 0; $x < count($config); $x++) {
                for ($y = 0; $y < count($config[$x]); $y++) {
                    $newConfig[$x][$y] = $this->animate($config, $x, $y);
                }
            }

            $config = $newConfig;
        }

        return GridHelper::count($config, '#');
    }

    /**
     * Day 18 Part 2
     */
    public function partTwo(int $steps = 100): string|int|null
    {
        $config = InputParser::grid($this->input);

        $config[0][0] = '#';
        $config[0][count($config) - 1] = '#';
        $config[count($config) - 1][0] = '#';
        $config[count($config) - 1][count($config) - 1] = '#';

        for ($i = 0; $i < $steps; $i++) {
            $newConfig = [];
            for ($x = 0; $x < count($config); $x++) {
                for ($y = 0; $y < count($config[$x]); $y++) {
                    $newConfig[$x][$y] = $this->animate($config, $x, $y, 2);
                }
            }

            $config = $newConfig;
        }

        return GridHelper::count($config, '#');
    }

    private function animate(array $config, int $x, int $y, int $part = 1): string
    {
        if (
            $part == 2
            && in_array($x, [0, count($config) - 1])
            && in_array($y, [0, count($config[$x]) - 1])
        ) {
            return '#';
        }

        $lightsOn = 0;
        $initialState = $config[$x][$y];

        foreach (GridHelper::allNeighbors($x, $y) as [$i, $j]) {
            if (GridHelper::inBounds($config, $i, $j) && $config[$i][$j] == '#') {
                $lightsOn++;
            }
        }

        return match ($initialState) {
            '#' => in_array($lightsOn, [2, 3]) ? '#' : '.',
            '.' => $lightsOn == 3 ? '#' : '.',
            default => null,
        };
    }
}
