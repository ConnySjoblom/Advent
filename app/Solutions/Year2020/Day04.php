<?php

namespace App\Solutions\Year2020;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day04 extends Solution
{
    /**
     * Day 04 Part 1
     */
    public function partOne(): string|int|null
    {
        $passports = collect(InputParser::groups($this->input))
            ->map(fn ($passport) => str($passport)
                ->explode("\n")
                ->implode(' '))
            /** @phpstan-ignore-next-line */
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
        $passports = collect(InputParser::groups($this->input))
            ->map(fn ($passport) => str($passport)
                ->explode("\n")
                ->implode(' '))
            /** @phpstan-ignore-next-line */
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
                    continue;
                }

                switch ($field) {
                    case 'byr':
                        $value = intval($passport[$field]);
                        if ($value < 1920 || $value > 2002) {
                            $valid = false;
                        }
                        break;

                    case 'iyr':
                        $value = intval($passport[$field]);
                        if ($value < 2010 || $value > 2020) {
                            $valid = false;
                        }
                        break;

                    case 'eyr':
                        $value = intval($passport[$field]);
                        if ($value < 2020 || $value > 2030) {
                            $valid = false;
                        }
                        break;

                    case 'hgt':
                        $value = intval(substr($passport[$field], 0, -2));
                        $unit = substr($passport[$field], -2, 2);

                        switch ($unit) {
                            case 'cm':
                                if ($value < 150 || $value > 193) {
                                    $valid = false;
                                }
                                break;
                            case 'in':
                                if ($value < 59 || $value > 76) {
                                    $valid = false;
                                }
                                break;
                            default:
                                $valid = false;
                                break;
                        }
                        break;

                    case 'hcl':
                        $value = $passport[$field];
                        if (!preg_match('/^#[a-f0-9]{6}$/i', $value)) {
                            $valid = false;
                        }
                        break;

                    case 'ecl':
                        $value = $passport[$field];
                        if (!preg_match('/^(amb|blu|brn|gry|grn|hzl|oth)$/i', $value)) {
                            $valid = false;
                        }
                        break;

                    case 'pid':
                        $value = $passport[$field];

                        if (strlen($value) != 9) {
                            $valid = false;
                        }
                        break;
                }
            }

            if ($valid) {
                $validPassports++;
            }
        }

        return $validPassports;
    }
}
