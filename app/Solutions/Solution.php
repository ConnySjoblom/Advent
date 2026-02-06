<?php

namespace App\Solutions;

use App\Data\PuzzleIdentifier;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Solution
{
    public string $input;

    public int $verbosity = OutputInterface::VERBOSITY_VERBOSE;

    public function __construct(PuzzleIdentifier|int|null $puzzleOrYear = null, ?int $day = null)
    {
        $puzzle = $puzzleOrYear instanceof PuzzleIdentifier
            ? $puzzleOrYear
            : (($puzzleOrYear !== null && $day !== null)
                ? new PuzzleIdentifier($puzzleOrYear, $day)
                : null);

        if ($puzzle !== null) {
            $this->input = trim(File::get($puzzle->inputPath()));
        }
    }

    abstract public function partOne(): string|int|null;

    abstract public function partTwo(): string|int|null;
}
