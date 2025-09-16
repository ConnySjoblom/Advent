<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2018\Day02();
});

test('Day 02 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
abcdef
bababc
abbcde
abcccd
aabcdd
abcdee
ababab
INPUT, '12'],
]);

test('Day 02 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
abcde
fghij
klmno
pqrst
fguij
axcye
wvxyz
INPUT, 'fgij'],
]);
