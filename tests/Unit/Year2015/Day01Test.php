<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2015\Day01();
});

test('Day 01 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
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

test('Day 01 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [')', '1'],
    ['()())', '5'],
]);
