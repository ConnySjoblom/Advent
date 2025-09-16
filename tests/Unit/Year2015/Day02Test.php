<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2015\Day02();
});

test('Day 02 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    ['2x3x4', '58'],
    ['1x1x10', '43'],
]);

test('Day 02 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    ['2x3x4', '34'],
    ['1x1x10', '14'],
]);
