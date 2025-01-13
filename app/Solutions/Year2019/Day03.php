<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day03 extends Solution
{
    public function partOne(): string
    {
        $lines = explode("\n", $this->input);

        $paths = [];
        foreach ($lines as $line) {
            $steps = explode(",", trim($line));

            $x = 0;
            $y = 0;
            $pos = [];
            foreach ($steps as $step) {
                $direction = substr($step, 0, 1);
                $count = intval(substr($step, 1));

                print(sprintf("%s: %d", $direction, $count) . "\n");

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
            $cordinates = explode(":", $intersection);
            $a = intval($cordinates[0]);
            $b = intval($cordinates[1]);

            $a = abs($a);
            $b = abs($b);

            $distance = $a + $b;

            print($intersection . " = " . $distance . "\n");

            if ($distance < $smallest) {
                $smallest = $distance;
            }
        }

        return $smallest;
    }

    public function partTwo(): string
    {
        $lines = explode("\n", $this->input);

        $paths = [];
        foreach ($lines as $line) {
            $steps = explode(",", trim($line));

            $x = 0;
            $y = 0;
            $pos = [];
            foreach ($steps as $step) {
                $direction = substr($step, 0, 1);
                $count = intval(substr($step, 1));

                print(sprintf("%s: %d", $direction, $count) . "\n");

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

            print($intersection . " = " . $distance . "\n");

            if ($distance < $smallest) {
                $smallest = $distance;
            }
        }

        return $smallest;
    }
}
