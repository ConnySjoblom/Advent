<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\IntcodeComputer;

class Day11 extends Solution
{
    private int $robotDirection = 0;
    private array $boatPanels = [];

    /**
     * Day 11 Part 1
     */
    public function partOne(): string|int|null
    {
        $computer = new IntcodeComputer($this->input);

        [$x, $y] = [0, 0];
        do {
            $computer->setInput($this->getCurrentColor($x, $y));

            [$color, $direction] = [$computer->run(), $computer->run()];

            $this->boatPanels["$x,$y"] = $color;

            [$x, $y] = $this->moveRobot($direction, $x, $y);
        } while ($computer->isRunning());

        return count($this->boatPanels);
    }

    /**
     * Day 11 Part 2
     */
    public function partTwo(): string|int|null
    {
        $computer = new IntcodeComputer($this->input);
        $computer->setInput(1);

        [$x, $y] = [0, 0];
        do {
            [$color, $direction] = [$computer->run(), $computer->run()];

            $this->boatPanels["$x,$y"] = $color;

            [$x, $y] = $this->moveRobot($direction, $x, $y);

            $computer->setInput($this->getCurrentColor($x, $y));
        } while ($computer->isRunning());

        return $this->render($this->boatPanels);
    }

    public function getCurrentColor(int $x, int $y): int
    {
        if (array_key_exists("$x,$y", $this->boatPanels)) {
            return $this->boatPanels["$x,$y"];
        }

        return 0;
    }

    private function moveRobot(int $direction, int $x, int $y): array
    {
        $this->robotDirection = match ($direction) {
            0 => ($this->robotDirection - 1 + 4) % 4,
            default => ($this->robotDirection + 1) % 4,
        };

        return match ($this->robotDirection) {
            0 => [$x, --$y],
            1 => [++$x, $y],
            2 => [$x, ++$y],
            default => [--$x, $y],
        };
    }

    private function render(array $boatPanels): string
    {
        array_pop($boatPanels); // Last item is exit code

        $maxX = $maxY = 0;
        $keys = array_keys($boatPanels);
        foreach ($keys as $key) {
            [$x, $y] = explode(',', $key);

            $maxX = max($maxX, $x);
            $maxY = max($maxY, $y);
        }

        $answer = "\n\n";
        for ($y = 0; $y <= $maxY; $y++) {
            for ($x = 0; $x <= $maxX; $x++) {
                if (array_key_exists("$x,$y", $boatPanels)) {
                    $answer .= $boatPanels["$x,$y"] == 0 ? '  ' : '██';
                } else {
                    $answer .= '  ';
                }
            }
            $answer .= "\n";
        }

        return $answer;
    }
}
