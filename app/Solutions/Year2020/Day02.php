<?php

namespace App\Solutions\Year2020;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $passwords = InputParser::lines($this->input);

        $valid = 0;
        foreach ($passwords as $password) {
            [$requirements, $password] = explode(': ', $password);
            [$limits, $char] = explode(' ', $requirements);
            [$min, $max] = InputParser::csvIntegers($limits, '-');

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
        $passwords = InputParser::lines($this->input);

        $valid = 0;
        foreach ($passwords as $password) {
            [$requirements, $password] = explode(': ', $password);
            [$limits, $char] = explode(' ', $requirements);
            [$a, $b] = InputParser::csvIntegers($limits, '-');

            $password = str_split($password);

            if ($password[$a - 1] == $char xor $password[$b - 1] == $char) {
                $valid++;
            }
        }

        return $valid;
    }
}
