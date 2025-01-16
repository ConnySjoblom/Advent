<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2024\Day01;
});

test('Day 01 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    [<<<'EOF'
3   4
4   3
2   5
1   3
3   9
3   3
EOF
        , '11'],
]);

test('Day 01 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    [<<<'EOF'
3   4
4   3
2   5
1   3
3   9
3   3
EOF
        , '31'],
]);
