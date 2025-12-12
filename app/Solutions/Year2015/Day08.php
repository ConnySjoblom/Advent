<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day08 extends Solution
{
    /**
     * Day 08 Part 1
     */
    public function partOne(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $output = '';
        foreach ($lines as $line) {
            $output .= eval("return $line;");
        }

        return strlen(implode('', $lines)) - strlen($output);
    }

    /**
     * Day 08 Part 2
     */
    public function partTwo(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $diff = 0;
        foreach ($lines as $line) {
            $diff += strlen(addslashes($line)) + 2 - strlen($line);
        }

        return $diff;
    }
}
