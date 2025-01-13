<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class Input
{
    public static function validate(?int $year, ?int $day, ?int $part = 1): array
    {
        if (empty($year)) {
            $year = match (intval(date('n'))) {
                12 => intval(date('Y')),
                default => intval(date('Y') - 1),
            };
        }

        Validator::validate(['year' => $year, 'day' => $day, 'part' => $part], [
            'year' => 'integer|between:2015,2024',
            'day' => 'integer|between:1,25',
            'part' => 'integer|between:1,2',
        ]);

        return [
            $year,
            $day,
            $part
        ];
    }
}
