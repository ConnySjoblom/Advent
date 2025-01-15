<?php

namespace App\Solutions;

use Illuminate\Support\Facades\File;

abstract class Solution
{
    public string $input;

    public function __construct(?int $year = null, ?int $day = null)
    {
        if (!is_null($year) && !is_null($day)) {
            $this->input = trim(File::get(storage_path(sprintf('input/%d_%02d_input.txt', $year, $day))));
        }
    }
}
