<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day08 extends Solution
{
    /**
     * Day 08 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = explode("\n", $this->input);

        $output = '';
        foreach ($input as $line) {
            $output .= eval("return $line;");
        }

        return strlen(implode('', $input)) - strlen($output);
    }

    /**
     * Day 08 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = explode("\n", $this->input);

        $diff = 0;
        foreach ($input as $line) {
            $diff += strlen(addslashes($line)) + 2 - strlen($line);
        }

        return $diff;
    }
}
