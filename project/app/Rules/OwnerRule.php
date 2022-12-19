<?php

namespace App\Rules;

use App\Helpers\SessionHelper;
use Egal\Validation\Rules\Rule as EgalRule;

class OwnerRule extends EgalRule
{
    /**
     * @throws \Exception
     */
    public function validate($attribute, $value, $parameters = null): bool
    {
        return SessionHelper::getAuthAttribute('id') === (int)$value;
    }

    public function message(): string
    {
        return 'You are not the owner!';
    }
}
