<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2019\Day04();
});

test('Day 04 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    ['111111-111111', '1'],
    ['223450-223450', '0'],
    ['123789-123789', '0']
]);

test('Day 04 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    ['112233-112233', '1'],
    ['123444-123444', '0'],
    ['111122-111122', '1'],
]);
