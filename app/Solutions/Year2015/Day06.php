<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day06 extends Solution
{
    /**
     * Day 06 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = explode("\n", $this->input);

        $lights = [];
        foreach ($input as $instruction) {
            preg_match('/(turn on|turn off|toggle) (\d{1,3}),(\d{1,3}) through (\d{1,3}),(\d{1,3})/', $instruction, $matches);

            $action = $matches[1];
            $fromX = $matches[2];
            $fromY = $matches[3];
            $toX = $matches[4];
            $toY = $matches[5];

            for ($x = $fromX; $x <= $toX; $x++) {
                for ($y = $fromY; $y <= $toY; $y++) {
                    if (!array_key_exists("$x:$y", $lights)) {
                        $lights["$x:$y"] = false;
                    }

                    switch ($action) {
                        case 'toggle':
                            $lights["$x:$y"] = !$lights["$x:$y"];
                            break;
                        case 'turn on':
                            $lights["$x:$y"] = true;
                            break;
                        case 'turn off':
                            $lights["$x:$y"] = false;
                            break;
                    }
                }
            }
        }

        return count(array_filter($lights));
    }

    /**
     * Day 06 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = explode("\n", $this->input);

        $lights = [];
        foreach ($input as $instruction) {
            preg_match('/(turn on|turn off|toggle) (\d{1,3}),(\d{1,3}) through (\d{1,3}),(\d{1,3})/', $instruction, $matches);

            $action = $matches[1];
            $fromX = $matches[2];
            $fromY = $matches[3];
            $toX = $matches[4];
            $toY = $matches[5];

            for ($x = $fromX; $x <= $toX; $x++) {
                for ($y = $fromY; $y <= $toY; $y++) {
                    if (!array_key_exists("$x:$y", $lights)) {
                        $lights["$x:$y"] = 0;
                    }

                    switch ($action) {
                        case 'toggle':
                            $lights["$x:$y"] += 2;
                            break;
                        case 'turn on':
                            $lights["$x:$y"] += 1;
                            break;
                        case 'turn off':
                            if ($lights["$x:$y"] > 0) {
                                $lights["$x:$y"] -= 1;
                            }
                            break;
                    }
                }
            }
        }

        return array_sum($lights);
    }
}
