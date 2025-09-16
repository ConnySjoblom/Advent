<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2015\Day10();
});

test('Day 10 Part 1 & 2', function (string $input, string $answer) {
    assertEquals($answer, test()->solution->lookAndSay($input));
})->with([
    ['1', '11'],
    ['11', '21'],
    ['21', '1211'],
    ['1211', '111221'],
    ['111221', '312211'],
]);
