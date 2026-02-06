<?php

namespace App\Exceptions;

use Exception;

class InvalidSessionException extends Exception
{
    public static function missing(): self
    {
        return new self('No AOC_SESSION configured. Add it to your .env file.');
    }

    public static function invalid(): self
    {
        return new self('AOC session is invalid or expired.');
    }
}
