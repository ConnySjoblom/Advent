<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day03 extends Solution
{
    /**
     * Day 3 Part 1
     */
    public function partOne(): string|int|null
    {
        $lines = explode("\n", $this->input);

        $paths = [];
        foreach ($lines as $line) {
            $steps = explode(',', $line);

            $x = 0;
            $y = 0;
            $pos = [];
            foreach ($steps as $step) {
                $direction = substr($step, 0, 1);
                $count = intval(substr($step, 1));

                switch ($direction) {
                    case 'R':
                        for ($i = 0; $i < $count; $i++) {
                            $x++;
                            $pos[] = "$x:$y";
                        }
                        break;
                    case 'L':
                        for ($i = 0; $i < $count; $i++) {
                            $x--;
                            $pos[] = "$x:$y";
                        }
                        break;
                    case 'U':
                        for ($i = 0; $i < $count; $i++) {
                            $y++;
                            $pos[] = "$x:$y";
                        }
                        break;
                    case 'D':
                        for ($i = 0; $i < $count; $i++) {
                            $y--;
                            $pos[] = "$x:$y";
                        }
                        break;
                }
            }

            $paths[] = $pos;
        }

        $smallest = PHP_INT_MAX;
        foreach (array_intersect($paths[0], $paths[1]) as $intersection) {
            $coordinates = explode(':', $intersection);
            $a = intval($coordinates[0]);
            $b = intval($coordinates[1]);

            $a = abs($a);
            $b = abs($b);

            $distance = $a + $b;

            if ($distance < $smallest) {
                $smallest = $distance;
            }
        }

        return $smallest;
    }

    /**
     * Day 3 Part 2
     */
    public function partTwo(): string|int|null
    {
        $lines = explode("\n", $this->input);

        $paths = [];
        foreach ($lines as $line) {
            $steps = explode(',', $line);

            $x = 0;
            $y = 0;
            $pos = [];
            foreach ($steps as $step) {
                $direction = substr($step, 0, 1);
                $count = intval(substr($step, 1));

                switch ($direction) {
                    case 'R':
                        for ($i = 0; $i < $count; $i++) {
                            $x++;
                            $pos[] = "$x:$y";
                        }
                        break;
                    case 'L':
                        for ($i = 0; $i < $count; $i++) {
                            $x--;
                            $pos[] = "$x:$y";
                        }
                        break;
                    case 'U':
                        for ($i = 0; $i < $count; $i++) {
                            $y++;
                            $pos[] = "$x:$y";
                        }
                        break;
                    case 'D':
                        for ($i = 0; $i < $count; $i++) {
                            $y--;
                            $pos[] = "$x:$y";
                        }
                        break;
                }
            }

            $paths[] = $pos;
        }

        $smallest = PHP_INT_MAX;
        foreach (array_intersect($paths[0], $paths[1]) as $intersection) {
            $a = array_search($intersection, $paths[0]) + 1;
            $b = array_search($intersection, $paths[1]) + 1;

            $distance = $a + $b;

            if ($distance < $smallest) {
                $smallest = $distance;
            }
        }

        return $smallest;
    }
}
