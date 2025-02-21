<?php

namespace App\Solutions\Year2020;

use App\Solutions\Solution;

class Day06 extends Solution
{
    /**
     * Day 06 Part 1
     */
    public function partOne(): string|int|null
    {
        $groups = explode("\n\n", $this->input);

        $answer = 0;
        foreach ($groups as $group) {
            $answers = str_split(implode('', explode("\n", $group)));
            $questions = array_unique($answers);

            $answer += count($questions);
        }

        return $answer;
    }

    /**
     * Day 06 Part 2
     */
    public function partTwo(): string|int|null
    {
        $groups = explode("\n\n", $this->input);

        $answer = 0;
        foreach ($groups as $group) {
            $group_answers = array_map('str_split', explode("\n", $group));
            $common_answers = call_user_func_array('array_intersect', $group_answers);

            $answer += count($common_answers);
        }

        return $answer;
    }
}
