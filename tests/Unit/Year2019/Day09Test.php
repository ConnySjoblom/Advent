<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2019\Day09();
});

test('Day 09', function (string $input, string $answer) {
    $computer = new \App\Solutions\Support\IntcodeComputer($input);

    do {
        $output[] = $computer->run();
    } while ($computer->isRunning());

    if (count($output) > 1) {
        array_pop($output);
    }

    assertEquals($answer, implode(',', $output));
})->with([
    ['109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99', '109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99'],
    ['104,1125899906842624,99', '1125899906842624'],
]);

test('Day 09 strlen()', function (string $input, string $answer) {
    $computer = new \App\Solutions\Support\IntcodeComputer($input);

    test()->assertTrue(strlen(strval($computer->run())) == 16);
})->with([
    ['1102,34915192,34915192,7,4,7,99,0', '109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99'],
]);
