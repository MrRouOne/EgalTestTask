<?php

namespace App\Exceptions;

use Exception;

class MatchOverException extends Exception
{
    protected $message = 'The match is already over. The winner is announced.';

    protected $code = 400;

}
