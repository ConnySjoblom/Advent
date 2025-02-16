<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day12 extends Solution
{
    /**
     * Day 12 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = json_decode($this->input, true);

        return $this->getSum($input);
    }

    /**
     * Day 12 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = json_decode($this->input, true);

        return $this->getSumTwo($input);
    }

    public function getSum(mixed $input): ?int
    {
        $sum = 0;

        switch (gettype($input)) {
            case 'integer':
                $sum = $input;
                break;
            case 'array':
                foreach ($input as $item) {
                    $sum += $this->getSum($item);
                }
        }

        return $sum;
    }

    public function getSumTwo(mixed $input): ?int
    {
        $sum = 0;
        switch (gettype($input)) {
            case 'integer':
                $sum += $input;
                break;
            case 'array':
                foreach ($input as $key => $value) {
                    if (!is_numeric($key) && $value == 'red') {
                        break 2;
                    }
                }

                foreach ($input as $item) {
                    $sum += $this->getSumTwo($item);
                }
        }

        return $sum;
    }
}
