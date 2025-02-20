<?php

namespace App\Solutions\Year2020;

use App\Solutions\Solution;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $passwords = explode("\n", $this->input);

        $valid = 0;
        foreach ($passwords as $password) {
            [$requirements, $password] = explode(': ', $password);
            [$limits, $char] = explode(' ', $requirements);
            [$min, $max] = explode('-', $limits);

            $occurrences = substr_count($password, $char);
            if ($occurrences < $min || $occurrences > $max) {
                continue;
            }

            $valid++;
        }

        return $valid;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): string|int|null
    {
        $passwords = explode("\n", $this->input);

        $valid = 0;
        foreach ($passwords as $password) {
            [$requirements, $password] = explode(': ', $password);
            [$limits, $char] = explode(' ', $requirements);
            [$a, $b] = array_map('intval', explode('-', $limits));

            $password = str_split($password);

            if ($password[$a - 1] == $char xor $password[$b - 1] == $char) {
                $valid++;
            }
        }

        return $valid;
    }
}
