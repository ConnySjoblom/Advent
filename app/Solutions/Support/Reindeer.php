<?php

namespace App\Solutions\Support;

use App\Solutions\Support\Enum\ReindeerState;

class Reindeer
{
    public int $distance = 0;

    private ReindeerState $state = ReindeerState::FLYING;

    private ?int $nextStateStep = null;

    public function __construct(
        public string $name,
        public int $speed,
        public int $flyingTime,
        public int $restingTime
    ) {
        //
    }

    public function move(int $step): void
    {
        $this->processStep();
        $this->verifyState($step);
    }

    private function processStep(): void
    {
        if ($this->nextStateStep == null) {
            $this->nextStateStep = $this->flyingTime;
        }

        if ($this->state == ReindeerState::FLYING) {
            $this->distance += $this->speed;
        }
    }

    private function verifyState(int $step): void
    {
        if ($this->nextStateStep == $step) {
            $this->state = Reindeerstate::from(1 - $this->state->value);

            switch ($this->state) {
                case ReindeerState::FLYING:
                    $this->nextStateStep = $step + $this->flyingTime;
                    break;
                case ReindeerState::RESTING:
                    $this->nextStateStep = $step + $this->restingTime;
                    break;
            }
        }
    }
}
