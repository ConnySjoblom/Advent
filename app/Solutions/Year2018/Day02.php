<?php

namespace App\Solutions\Year2018;

use App\Solutions\Solution;

class Day02 extends Solution
{
    /**
     * Day 02 Part 1
     */
    public function partOne(): ?string
    {
        $input = explode("\n", $this->input);

        $twice = 0;
        $thrice = 0;
        foreach ($input as $id) {
            $charCounts = [];
            foreach (array_unique(str_split($id)) as $char) {
                $charCounts[$char] = count(array_filter(str_split($id), fn ($value) => $value == $char));
            }

            if (array_search(2, $charCounts)) {
                $twice++;
            }
            if (array_search(3, $charCounts)) {
                $thrice++;
            }
        }

        return sprintf('%d', $twice * $thrice);
    }

    /**
     * Day 02 Part 2
     */
    public function partTwo(): ?string
    {
        $input = explode("\n", $this->input);

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
