<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;

class Day06 extends Solution
{
    /**
     * Day 06 Part 1
     */
    public function partOne(): string|int|null
    {
        $banks = array_map(
            fn ($bank) => intval($bank),
            explode("\t", $this->input)
        );

        $cycles = 0;
        $memories = [];
        while (true) {
            $bank = array_search(max($banks), $banks);

            $items = $banks[$bank];
            $banks[$bank] = 0;

            while ($items > 0) {
                $bank = ($bank + 1) % count($banks);
                $banks[$bank]++;
                $items--;
            }

            $cycles++;

            if (in_array(implode(',', $banks), $memories)) {
                return $cycles;
            }

            $memories[] = implode(',', $banks);
        }
    }

    /**
     * Day 06 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
