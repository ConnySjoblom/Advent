<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = str_split($this->input);

        [$x, $y] = [0, 0];
        $houses['0:0'] = 1;
        foreach ($input as $index => $char) {
            switch ($char) {
                case '^': // North
                    $y++;
                    break;
                case 'v': // South
                    $y--;
                    break;
                case '>': // East
                    $x++;
                    break;
                case '<': // West
                    $x--;
                    break;
            }

            if (! array_key_exists("$x:$y", $houses)) {
                $houses["$x:$y"] = 0;
            }

            $houses["$x:$y"] += 1;
        }

        return count($houses);
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = str_split($this->input);

        $houses['0:0'] = 2;
        [$x[0], $y[0], $x[1], $y[1]] = [0, 0, 0, 0];

        foreach ($input as $index => $char) {
            switch ($char) {
                case '^': // North
                    $y[$index % 2]++;
                    break;
                case 'v': // South
                    $y[$index % 2]--;
                    break;
                case '>': // East
                    $x[$index % 2]++;
                    break;
                case '<': // West
                    $x[$index % 2]--;
                    break;
            }

            $house = sprintf('%s:%s', $x[$index % 2], $y[$index % 2]);
            if (! array_key_exists($house, $houses)) {
                $houses[$house] = 0;
            }

            $houses[$house] += 1;
        }

        return count($houses);
    }
}
