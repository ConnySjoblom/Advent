<?php

namespace App\Solutions\Support;

class Reindeer
{
    public int $distance = 0;

    private int $state = 1; // 1 = Flying, 0 = Resting

    private ?int $flyingNext = null;

    private ?int $restingNext = null;

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
        $this->verifyState($step);
        $this->fly();
        $this->setTimes($step);
    }

    private function fly(): void
    {
        switch ($this->state) {
            case 1:
                $this->distance += $this->speed;
                break;
            default:
                break;
        }
    }

    private function verifyState(int $step): void
    {
        switch ($this->state) {
            case 0:
                if ($this->flyingNext == $step) {
                    $this->state = 1;
                    $this->flyingNext = null;
                }
                break;
            case 1:
                if ($this->restingNext == $step) {
                    $this->state = 0;
                    $this->restingNext = null;
                }
                break;
        }
    }

    private function setTimes(int $step): void
    {
        switch ($this->state) {
            case 0:
                if (is_null($this->flyingNext)) {
                    $this->flyingNext = $step + $this->restingTime;
                }
                break;
            case 1:
                if (is_null($this->restingNext)) {
                    $this->restingNext = $step + $this->flyingTime;
                }
                break;
        }
    }
}
