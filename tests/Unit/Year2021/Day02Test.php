<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2021\Day02();
});

test('Day 02 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    [<<<INPUT
forward 5
down 5
forward 8
up 3
down 8
forward 2
INPUT
        , '150'],
]);

test('Day 02 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    [<<<INPUT
forward 5
down 5
forward 8
up 3
down 8
forward 2
INPUT
        , '900'],
]);
