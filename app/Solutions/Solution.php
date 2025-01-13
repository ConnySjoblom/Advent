<?php

namespace App\Solutions;

use Illuminate\Support\Facades\File;

abstract class Solution
{
    protected string $input;

    public function __construct(int $year, int $day)
    {
        $this->input = File::get(storage_path(sprintf('input/%d_%02d_input.txt', $year, $day)));
    }
}
