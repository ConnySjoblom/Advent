<?php

namespace App\Enums;

enum Part: int
{
    case One = 1;
    case Two = 2;

    public function method(): string
    {
        return match ($this) {
            self::One => 'partOne',
            self::Two => 'partTwo',
        };
    }
}
