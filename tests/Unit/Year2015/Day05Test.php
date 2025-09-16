<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2015\Day05();
});

test('Day 05 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    ['ugknbfddgicrmopn', '1'],
    ['aaa', '1'],
    ['jchzalrnumimnmhp', '0'],
    ['haegwjzuvuyypxyu', '0'],
    ['dvszwmarrgswjxmb', '0'],
]);

test('Day 05 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    ['qjhvhtzxzqqjkmpb', '1'],
    ['xxyxx', '1'],
    ['uurcxstgmygtbstg', '0'],
    ['ieodomkazucvgmuy', '0'],
]);
