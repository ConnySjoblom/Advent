<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2015\Day11;
});

test('Day 11 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    ['', ''],
])->skip('No test implemented yet.');

test('Day 11 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    ['', ''],
])->skip('No test implemented yet.');
