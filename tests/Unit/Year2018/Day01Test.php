<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2018\Day01();
});

test('Day 01 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    ["+1\n+1\n+1", '3'],
    ["+1\n+1\n-2", '0'],
    ["-1\n-2\n-3", '-6'],
]);

test('Day 01 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    ["+1\n-1", '0'],
    ["+3\n+3\n+4\n-2\n-4", '10'],
    ["-6\n+3\n+8\n+5\n-6", '5'],
    ["+7\n+7\n-2\n-7\n-4", '14'],
]);
