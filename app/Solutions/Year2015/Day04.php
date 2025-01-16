<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): ?string
    {
        $input = trim($this->input);

        for ($i = 0; $i < PHP_INT_MAX; $i++) {
            $hex = md5($input.$i);

            if (str_starts_with($hex, '00000')) {
                return $i;
            }
        }

        return null;
    }

    /**
     * Day 04 Part 2
     */
    public function partTwo(): ?string
    {
        $input = trim($this->input);

        for ($i = 0; $i < PHP_INT_MAX; $i++) {
            $hex = md5($input.$i);

            if (str_starts_with($hex, '000000')) {
                return $i;
            }
        }

        return null;
    }
}
