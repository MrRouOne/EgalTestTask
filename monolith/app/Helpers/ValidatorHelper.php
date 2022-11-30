<?php

namespace App\Helpers;

use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class ValidatorHelper
{
    public static function validate($data, $rules) {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());
            throw $exception;
        }
    }
}
