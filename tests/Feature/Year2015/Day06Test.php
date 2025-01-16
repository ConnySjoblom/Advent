<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2015\Day06;
});

test('Day 06 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    ['turn on 0,0 through 999,999', '1000000'],
    ['toggle 0,0 through 999,0', '1000'],
]);

test('Day 06 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    ['turn on 0,0 through 0,0', '1'],
    ['toggle 0,0 through 999,999', '2000000'],
]);
