<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $banks = array_map('str_split', explode("\n", $this->input));

        $answer = 0;
        foreach ($banks as $bank) {
            $max = 0;
            $len = count($bank);
            for ($i = 0; $i < $len - 1; $i++) {
                for ($j = $i + 1; $j < $len; $j++) {
                    $max = max($max, (int)($bank[$i] . $bank[$j]));
                }
            }
            $answer += $max;
        }

        return $answer;
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        $banks = array_map('str_split', explode("\n", $this->input));

        $answer = 0;
        foreach ($banks as $bank) {

            $start = 0;
            $bankSize = count($bank);
            $bankBattery = [];
            for ($i = 0; $i < 12; $i++) {

                $max = $bankSize - (12 - $i) + 1;
                $maxBattery = 0;
                $maxPosition = 0;
                for ($j = $start; $j < $max; $j++) {
                    if ($maxBattery < $bank[$j]) {
                        $maxBattery = $bank[$j];
                        $maxPosition = $j;
                    }
                }

                $start = $maxPosition + 1;
                $bankBattery[] = $maxBattery;
            }

            $answer += (int)implode('', $bankBattery);
        }

        return $answer;
    }
}
