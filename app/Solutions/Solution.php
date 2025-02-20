<?php

namespace App\Solutions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

abstract class Solution
{
    public string $input;

    private Command $command;

    public function __construct(Command $command, ?int $year = null, ?int $day = null)
    {
        $this->command = $command;

        if (!is_null($year) && !is_null($day)) {
            $this->input = trim(File::get(storage_path(sprintf('input/%d_%02d_input.txt', $year, $day))));
        }
    }
}
