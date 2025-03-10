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
    public function partTwo(int $steps = 100): string|int|null
    {
        $input = explode("\n", $this->input);

        $config = [];
        for ($i = 0; $i < count($input); $i++) {
            $config[$i] = str_split($input[$i]);
        }

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

        $lightsOn = 0;
        for ($i = 0; $i < count($config); $i++) {
            $count = array_count_values($config[$i]);
            if (isset($count['#'])) {
                $lightsOn += array_count_values($config[$i])['#'];
            }
        }

        return $lightsOn;
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
