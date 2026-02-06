<?php

namespace App\Data;

readonly class PuzzleIdentifier
{
    public function __construct(
        public int $year,
        public int $day,
        public int $part = 1,
    ) {
    }

    public function inputPath(): string
    {
        return storage_path(sprintf('input/%d_%02d_input.txt', $this->year, $this->day));
    }

    public function solutionClass(): string
    {
        return sprintf('App\\Solutions\\Year%d\\Day%02d', $this->year, $this->day);
    }

    public function solutionPath(): string
    {
        return app_path(sprintf('Solutions/Year%d/Day%02d.php', $this->year, $this->day));
    }

    public function testPath(): string
    {
        return base_path(sprintf('tests/Unit/Year%d/Day%02dTest.php', $this->year, $this->day));
    }
}
