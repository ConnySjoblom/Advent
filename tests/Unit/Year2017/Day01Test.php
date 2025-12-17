<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2017\Day01();
});

test('Day 01 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    ['1122', '3'],
    ['1111', '4'],
    ['1234', '0'],
    ['91212129', '9'],
]);

test('Day 01 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    ['1212', '6'],
    ['1221', '0'],
    ['123425', '4'],
    ['123123', '12'],
    ['12131415', '4'],
]);
