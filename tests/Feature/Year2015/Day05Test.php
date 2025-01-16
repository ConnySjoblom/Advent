<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2015\Day05;
});

test('Day 05 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    ['', ''],
])->skip();

test('Day 05 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    ['', ''],
])->skip();
