<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day18 extends Solution
{
    /**
     * Day 18 Part 1
     */
    public function partOne(int $steps = 100): string|int|null
    {
        $input = explode("\n", $this->input);

        $config = [];
        for ($i = 0; $i < count($input); $i++) {
            $config[$i] = str_split($input[$i]);
        }

        for ($i = 0; $i < $steps; $i++) {
            $newConfig = [];
            for ($x = 0; $x < count($config); $x++) {
                for ($y = 0; $y < count($config[$x]); $y++) {
                    $newConfig[$x][$y] = $this->animate($config, $x, $y);
                }
            }

            $config = $newConfig;
        }

        $lightsOn = 0;
        for ($i = 0; $i < count($config); $i++) {
            $count = array_count_values($config[$i]);
            if (isset($count['#'])) {
                $lightsOn += array_count_values($config[$i])['#'];
            }
        }

        return $lightsOn;
    }

    /**
     * Day 18 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }

    private function animate(array $config, int $x, int $y): string
    {
        $lightsOn = 0;
        $initialState = $config[$x][$y];
        for ($i = $x - 1; $i <= $x + 1; $i++) {
            for ($j = $y - 1; $j <= $y + 1; $j++) {
                if (
                    ($i == $x && $j == $y)
                    || $i < 0 || $j < 0
                    || $i > count($config) - 1
                    || $j > count($config[$x]) - 1
                ) {
                    continue;
                }

                if ($config[$i][$j] == '#') {
                    $lightsOn++;
                }
            }
        }

        return match ($initialState) {
            '#' => in_array($lightsOn, [2, 3]) ? '#' : '.',
            '.' => $lightsOn == 3 ? '#' : '.',
            default => null,
        };
    }
}
