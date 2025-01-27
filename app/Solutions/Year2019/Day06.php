<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use Illuminate\Support\Collection;

class Day06 extends Solution
{
    private Collection $memory;
    private Collection $objects;

    public function __construct(?int $year = null, ?int $day = null)
    {
        parent::__construct($year, $day);

        $this->memory = new Collection();
    }

    /**
     * Day 06 Part 1
     */
    public function partOne(): string|int|null
    {
        $this->objects = collect(explode("\n", $this->input))
            ->map(fn ($object) => collect(explode(')', $object)))
            ->mapWithKeys(fn ($object) => [$object[1] => $object[0]]);

        $orbits = 0;
        foreach ($this->objects->keys() as $object) {
            $orbits += $this->getOrbits($object);
        }

        return $orbits;
    }

    /**
     * Day 06 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }

    private function getOrbits(string $object): int
    {
        if ($this->memory->has($object)) {
            return $this->memory->get($object);
        }

        $orbits = 0;
        if ($this->objects->has($object)) {
            $orbits += $this->getOrbits($this->objects->get($object));
            $orbits++;
        }

        $this->memory->put($object, $orbits);

        return $orbits;
    }
}
