<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {
        [$min, $max] = collect(explode('-', $this->input))->map(fn ($value) => intval($value));

        $matches = 0;
        for ($i = $min; $i <= $max; $i++) {
            preg_match('/(\d)\1/', $i, $match);
            if (count($match) < 1) {
                continue;
            }

            $p = str_split(strval($i));
            asort($p);
            if ($i != intval(implode('', $p))) {
                continue;
            }

            $matches++;
        }

        return $matches;
    }

    /**
     * Day 04 Part 2
     */
    public function partTwo(): string|int|null
    {
        [$min, $max] = collect(explode('-', $this->input))->map(fn ($value) => intval($value));

        $matches = 0;
        for ($i = $min; $i <= $max; $i++) {
            if (collect(str_split(strval($i)))->sort()->implode(null) != strval($i)) {
                continue;
            }

            if (
                str($i)
                    ->split('/(.)\1*\K/', flags: PREG_SPLIT_NO_EMPTY)
                    ->filter(fn ($value) => strlen($value) == 2)
                    ->count() < 1
            ) {
                continue;
            }

            $matches++;
        }

        return $matches;
    }
}
