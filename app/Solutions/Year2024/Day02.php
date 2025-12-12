<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $reports = InputParser::lines($this->input);

        $safeNum = 0;
        foreach ($reports as $report) {
            $safe = true;
            $report = InputParser::csvIntegers($report, ' ');
            $origin = implode(' ', $report);
            for ($i = 0; $i < count($report) - 1; $i++) {
                if (
                    abs($report[$i] - $report[$i + 1]) < 1
                    || abs($report[$i] - $report[$i + 1]) > 3
                ) {
                    $safe = false;
                }
            }

            asort($report);
            $a = implode(' ', $report);

            arsort($report);
            $ar = implode(' ', $report);

            if (($origin != $a) && ($origin != $ar)) {
                $safe = false;
            }

            if ($safe) {
                $safeNum++;
            }
        }

        return $safeNum;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): string|int|null
    {
        $reports = InputParser::lines($this->input);

        $safe = 0;
        foreach ($reports as $report) {
            $safe += $this->isSafe(InputParser::csvIntegers($report, ' '));
        }

        return $safe;
    }

    private function isSafe(array $array): int
    {
        $safe = $this->checkSafe($array);

        if ($safe) {
            return 1;
        }
        for ($i = 0; $i < count($array); $i++) {
            $new_array = $array;
            unset($new_array[$i]);

            if ($this->checkSafe(array_values($new_array))) {
                return 1;
            }
        }


        return 0;
    }

    private function checkSafe(array $report): int
    {
        $safe = true;
        $origin = implode(' ', $report);
        for ($i = 0; $i < count($report) - 1; $i++) {
            if (
                abs($report[$i] - $report[$i + 1]) < 1
                || abs($report[$i] - $report[$i + 1]) > 3
            ) {
                $safe = false;
            }
        }

        asort($report);
        $a = implode(' ', $report);

        arsort($report);
        $ar = implode(' ', $report);

        if (($origin != $a) && ($origin != $ar)) {
            $safe = false;
        }

        if ($safe) {
            return 1;
        }

        return 0;
    }


}
