<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day20 extends Solution
{
    /**
     * Day 20 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = intval($this->input);

        $houses = array_fill(0, $input / 10, 0);
        for ($elf = 1; $elf < count($houses); $elf++) {
            for ($i = $elf; $i < count($houses); $i += $elf) {
                $houses[$i] += $elf * 10;
            }
        }

        return array_find_key($houses, fn ($presents) => $presents >= $input);
    }

    /**
     * Day 20 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = intval($this->input);

        $houses = array_fill(0, $input / 10, 0);
        for ($elf = 1; $elf < count($houses); $elf++) {
            $visited = 0;
            for ($i = $elf; $i < count($houses); $i += $elf) {
                $houses[$i] += $elf * 11;
                $visited++;

                if ($visited >= 50) {
                    break;
                }
            }
        }

        return array_find_key($houses, fn ($presents) => $presents >= $input);
    }
}
