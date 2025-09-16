<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2015\Day03();
});

test('Day 03 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    ['>', '2'],
    ['^>v<', '4'],
    ['^v^v^v^v^v', '2'],
]);

test('Day 03 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    ['^v', '3'],
    ['^>v<', '3'],
    ['^v^v^v^v^v', '11'],
]);
