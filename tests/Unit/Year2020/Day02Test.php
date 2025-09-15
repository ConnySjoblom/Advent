<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2020\Day02();
});

test('Day 02 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    [<<<INPUT
1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
INPUT
        , '2'],
]);

test('Day 02 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    [<<<INPUT
1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
INPUT
        , '1'],
]);
