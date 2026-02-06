<?php

namespace App\Support;

use App\Data\PuzzleIdentifier;
use Illuminate\Support\Facades\Validator;

class Input
{
    public static function validate(?int $year, ?int $day, ?int $part = 1): PuzzleIdentifier
    {
        $curMonth = intval(date('n'));
        $maxYear = match ($curMonth) {
            12 => intval(date('Y')),
            default => intval(date('Y') - 1),
        };

        // If year is empty, fallback to latest available year
        if (empty($year)) {
            $year = $maxYear;

            // If both year and day are empty, also default day to current day
            if (empty($day)) {
                $day = intval(date('d'));
            }
        }

        Validator::validate(['year' => $year, 'day' => $day, 'part' => $part], [
            'year' => 'integer|between:' . config('aoc.first_year') . ',' . $maxYear,
            'day' => 'required|integer|between:1,' . config('aoc.max_day'),
            'part' => 'integer|between:1,2',
        ]);

        return new PuzzleIdentifier(
            year: $year,
            day: $day,
            part: $part,
        );
    }
}
