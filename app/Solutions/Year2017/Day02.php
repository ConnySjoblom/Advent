<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $rows = array_map(
            fn ($row) => array_map('intval', explode("\t", $row)),
            InputParser::lines($this->input)
        );

        $checksum = 0;
        foreach ($rows as $row) {
            $checksum += max($row) - min($row);
        }

        return $checksum;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): string|int|null
    {
        $rows = array_map(
            fn ($row) => array_map('intval', explode("\t", $row)),
            InputParser::lines($this->input)
        );

        $checksum = 0;
        foreach ($rows as $index => $row) {
            for ($i = 0; $i < count($row); $i++) {
                for ($j = 0; $j < count($row); $j++) {
                    if ($i === $j) {
                        continue;
                    }

                    if (is_int($row[$i] / $row[$j])) {
                        $checksum += $row[$i] / $row[$j];
                    }
                }
            }
        }

        return $checksum;
    }
}
