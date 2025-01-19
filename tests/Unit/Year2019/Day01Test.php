<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2019\Day01();
});

test('Day 01 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    ['12', '2'],
    ['14', '2'],
    ['1969', '654'],
    ['100756', '33583'],
]);

test('Day 01 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    ['1969', '966'],
    ['100756', '50346'],
]);
