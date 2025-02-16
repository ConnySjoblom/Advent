<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day10 extends Solution
{
    /**
     * Day 10 Part 1
     */
    public function partOne(): string|int|null
    {
        $times = 40;
        $input = $this->input;

        for ($i = 0; $i < $times; $i++) {
            $input = $this->lookAndSay($input);
        }

        return strlen($input);
    }

    /**
     * Day 10 Part 2
     */
    public function partTwo(): string|int|null
    {
        $times = 50;
        $input = $this->input;

        for ($i = 0; $i < $times; $i++) {
            $input = $this->lookAndSay($input);
        }

        return strlen($input);
    }

    public function lookAndSay(string $input): string
    {
        preg_match_all('/((\d)\2*)/', $input, $matches, PREG_SET_ORDER, 0);

        $result = '';
        foreach ($matches as $match) {
            $result .= sprintf('%d%s', strlen($match[0]), $match[2]);
        }

        return $result;
    }
}
