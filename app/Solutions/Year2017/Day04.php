<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {
        $passphrases = explode("\n", $this->input);

        $valid = 0;
        foreach ($passphrases as $passphrase) {
            $words = explode(' ', $passphrase);

            $match = false;
            foreach ($words as $index => $word) {
                for ($i = $index + 1; $i < count($words); $i++) {
                    if ($word === $words[$i]) {
                        $match = true;
                    }
                }
            }

            if (!$match) {
                $valid++;
            }
        }

        return $valid;
    }

    /**
     * Day 04 Part 2
     */
    public function partTwo(): string|int|null
    {
        $passphrases = explode("\n", $this->input);

        $valid = 0;
        foreach ($passphrases as $passphrase) {
            $words = explode(' ', $passphrase);

            $match = false;
            foreach ($words as $index => $word) {
                $str = str_split($word);
                sort($str, SORT_STRING);
                $str = implode('', $str);
                for ($i = $index + 1; $i < count($words); $i++) {
                    $cstr = str_split($words[$i]);
                    sort($cstr, SORT_STRING);
                    $cstr = implode('', $cstr);

                    if (
                        $word === $words[$i]
                        || $str == $cstr
                    ) {
                        $match = true;
                    }
                }
            }

            if (!$match) {
                $valid++;
            }
        }

        return $valid;
    }
}
