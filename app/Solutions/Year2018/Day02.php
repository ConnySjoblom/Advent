<?php

namespace App\Solutions\Year2018;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::lines($this->input);

        $twice = 0;
        $thrice = 0;
        foreach ($input as $id) {
            $charCounts = array_count_values(str_split($id));

            if (in_array(2, $charCounts)) {
                $twice++;
            }
            if (in_array(3, $charCounts)) {
                $thrice++;
            }
        }

        return $twice * $thrice;
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::lines($this->input);

        do {
            $box = array_pop($input);

            foreach ($input as $id) {
                $idArray = str_split($id);
                $boxArray = str_split($box);

                $diffs = 0;
                for ($i = 0; $i < count($boxArray); $i++) {
                    if ($boxArray[$i] != $idArray[$i]) {
                        $diffs++;
                    }
                }

                $answer = '';
                if ($diffs == 1) {
                    for ($i = 0; $i < count($boxArray); $i++) {
                        if ($boxArray[$i] == $idArray[$i]) {
                            $answer .= $boxArray[$i];
                        }
                    }

                    return $answer;
                }
            }
        } while (count($input));

        return null;
    }
}
