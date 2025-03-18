<?php

namespace App\Solutions\Support;

class IntcodeComputer
{
    protected int $pointer = 0;

    protected int $relative_base = 0;

    protected array $input = [];

    protected array $memory;

    protected bool $halted = false;

    public function __construct(string $memory)
    {
        $this->memory = array_map('intval', explode(',', $memory));
    }

    public function setInput(int $input): void
    {
        $this->input[] = $input;
    }

    public function setMemory(int $position, int $memory): void
    {
        $this->memory[$position] = $memory;
    }

    public function isHalted(): bool
    {
        return $this->halted;
    }

    public function run(): null|int
    {
        while ($this->pointer < count($this->memory)) {
            $op = $this->getOp();

            switch ($op) {
                case 99:
                    $this->halted = true;
                    return -2;

                case 1: # Addition
                    $term1 = $this->readMemoryOffset(1);
                    $term2 = $this->readMemoryOffset(2);

                    $this->writeMemoryOffset(3, $term1 + $term2);

                    $this->pointer += 4;
                    break;

                case 2: # Multiplication
                    $factor1 = $this->readMemoryOffset(1);
                    $factor2 = $this->readMemoryOffset(2);

                    $this->writeMemoryOffset(3, $factor1 * $factor2);

                    $this->pointer += 4;
                    break;

                case 3: # Write
                    $this->writeMemoryOffset(1, array_shift($this->input));

                    $this->pointer += 2;
                    break;

                case 4: # Read
                    $output = $this->readMemoryOffset(1);

                    $this->pointer += 2;

                    return $output;

                case 5: # Jump if true
                    $param1 = $this->readMemoryOffset(1);
                    $param2 = $this->readMemoryOffset(2);

                    if ($param1 > 0) {
                        $this->pointer = $param2;
                        break;
                    }

                    $this->pointer += 3;
                    break;

                case 6: # Jump if false
                    $param1 = $this->readMemoryOffset(1);
                    $param2 = $this->readMemoryOffset(2);

                    if ($param1 == 0) {
                        $this->pointer = $param2;
                        break;
                    }

                    $this->pointer += 3;
                    break;

                case 7: # Less than
                    $param1 = $this->readMemoryOffset(1);
                    $param2 = $this->readMemoryOffset(2);

                    $data = ($param1 < $param2) ? 1 : 0;

                    $this->writeMemoryOffset(3, $data);

                    $this->pointer += 4;
                    break;

                case 8: # Equals
                    $param1 = $this->readMemoryOffset(1);
                    $param2 = $this->readMemoryOffset(2);

                    $data = ($param1 == $param2) ? 1 : 0;

                    $this->writeMemoryOffset(3, $data);

                    $this->pointer += 4;
                    break;

                case 9: # Adjust relative base
                    $param1 = $this->readMemoryOffset(1);

                    $this->relative_base += $param1;

                    $this->pointer += 2;

                    break;
            }
        }

        return 0; // this should not happen?!
    }

    private function getOpStr(): string
    {
        return str_pad($this->memory[$this->pointer], 5, '0', STR_PAD_LEFT);
    }

    private function getOp(): int
    {
        return (int)substr($this->getOpStr(), -2);
    }

    private function readMemoryOffset(int $offset): int
    {
        $accessMode = (int)substr($this->getOpStr(), -2 - $offset, 1);

        $address = $this->pointer + $offset;
        if (!array_key_exists($address, $this->memory)) {
            return 0;
        }

        switch ($accessMode) {
            case 1:
                return $this->memory[$address];

            case 2:
                $address = $this->memory[$address] + $this->relative_base;
                if (!array_key_exists($address, $this->memory)) {
                    return 0;
                }

                return $this->memory[$address];

            default: // 0 is considered default behaviour
                $address = $this->memory[$address];
                if (!array_key_exists($address, $this->memory)) {
                    return 0;
                }

                return $this->memory[$address];
        }
    }

    private function writeMemoryOffset(int $offset, int $data): void
    {
        $accessMode = (int)substr($this->getOpStr(), -2 - $offset, 1);

        switch ($accessMode) {
            case 2:
                $this->memory[$this->memory[$this->pointer + $offset] + $this->relative_base] = $data;
                break;
            default:
                $this->memory[$this->memory[$this->pointer + $offset]] = $data;
        }
    }
}
