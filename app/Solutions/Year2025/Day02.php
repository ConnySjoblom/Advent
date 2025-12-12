<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $sum = 0;
        foreach (InputParser::csv($this->input) as $id_range) {
            $parts = InputParser::csvIntegers($id_range, '-');
            for ($i = $parts[0]; $i <= $parts[1]; $i++) {
                $strlen = strlen(strval($i));
                if ($strlen % 2 == 0) {
                    $id_parts = str_split(strval($i), $strlen / 2);
                    if ($id_parts[0] == $id_parts[1]) {
                        $sum += $i;
                    }
                }
            }
        }

        return $sum;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): string|int|null
    {
        $sum = 0;
        foreach (InputParser::csv($this->input) as $id_range) {
            $parts = InputParser::csvIntegers($id_range, '-');
            for ($i = $parts[0]; $i <= $parts[1]; $i++) {
                $strlen = strlen(strval($i));
                for ($j = 1; $j <= $strlen / 2; $j++) {
                    $needle = substr(strval($i), 0, $j);
                    if ($this->isRepeating($needle, $i)) {
                        $sum += $i;
                        break;
                    }
                }
            }
        }

        return $sum;
    }

    private function isRepeating($needle, $haystack): bool
    {
        $parts = str_split($haystack, strlen($needle));
        for ($i = 1; $i < count($parts); $i++) {
            if ($needle != $parts[$i]) {
                return false;
            }
        }

        return true;
    }
}
