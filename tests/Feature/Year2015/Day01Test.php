<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2015\Day01;
});

test('Day 1 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    ['(())', '0'],
    ['()()', '0'],
    ['(((', '3'],
    ['(()(()(', '3'],
    ['))(((((', '3'],
    ['())', '-1'],
    ['))(', '-1'],
    [')))', '-3'],
    [')())())', '-3'],
]);

test('Day 1 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    [')', '1'],
    ['()())', '5'],
]);
