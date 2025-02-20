<?php

namespace App\Solutions\Year2020;

use App\Solutions\Solution;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {
        $passports = str($this->input)
            ->explode("\n\n")
            ->map(fn ($passport) => str($passport)
                ->explode("\n")
                ->implode(' '))
            ->map(fn ($passport) => str($passport)
                ->explode(' ')
                ->mapWithKeys(function ($passport) {
                    $field = str($passport)->explode(':');
                    return [$field->shift() => $field->shift()];
                }))
            ->toArray();

        $required = [
            'byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'
        ];

        $validPassports = 0;
        foreach ($passports as $passport) {
            $valid = true;
            foreach ($required as $field) {
                if (!array_key_exists($field, $passport)) {
                    $valid = false;
                }
            }

            if ($valid) {
                $validPassports++;
            }
        }

        return $validPassports;
    }

    /**
     * Day 04 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
