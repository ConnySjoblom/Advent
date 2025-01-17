<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day11 extends Solution
{
    /**
     * Day 11 Part 1
     */
    public function partOne(): ?string
    {
        $password = trim($this->input);
        // ord() - 96 :: a = 1, b = 2 => chr()

        $invalidPassword = true;
        while ($invalidPassword) {
            $password = $this->incrementString($password);

            $increasing = false;
            $noIllegalChars = false;
            $pairsOfLetters = false;
            $passwordParts = str_split($password);
            for ($i = 0; $i < strlen($password) - 2; $i++) {
                $a = $this->charToInt($passwordParts[$i]);
                $b = $this->charToInt($passwordParts[$i + 1]);
                $c = $this->charToInt($passwordParts[$i + 2]);

                if (
                    $a + 1 == $b
                    && $b + 1 == $c
                ) {
                    $increasing = true;
                }
            }

            if (
                ! array_key_exists($this->charToInt('i'), $passwordParts)
                && ! array_key_exists($this->charToInt('o'), $passwordParts)
                && ! array_key_exists($this->charToInt('l'), $passwordParts)
            ) {
                $noIllegalChars = true;
            }

            preg_match_all('/(\w)\1/', $password, $matches);
            if (count($matches[0]) > 1) {
                $pairsOfLetters = true;
            }

            if (
                $increasing
                && $noIllegalChars
                && $pairsOfLetters
            ) {
                $invalidPassword = false;
            }
        }

        return $password;
    }

    /**
     * Day 11 Part 2
     */
    public function partTwo(): ?string
    {
        $this->input = $this->partOne();
        $this->input = $this->incrementString($this->input);

        return $this->partOne();
    }

    public function incrementString(mixed $string, ?int $position = null): mixed
    {
        $implode = false;

        if (is_string($string)) {
            $string = str_split($string);
        }

        if (is_null($position)) {
            $implode = true;
        }

        $position = $position ?: count($string) - 1;
        $nextChar = $this->charToInt($string[$position]) + 1;

        // 26 = z
        if ($nextChar > 26) {
            $string[$position] = $this->intToChar(1);
            $string = $this->incrementString($string, $position - 1);
        } else {
            $string[$position] = $this->intToChar($nextChar);
        }

        if ($implode) {
            $string = implode('', $string);
        }

        return $string;
    }

    private function charToInt(string $char): int
    {
        return ord($char) - 96;
    }

    private function intToChar(int $int): string
    {
        return chr($int + 96);
    }
}
