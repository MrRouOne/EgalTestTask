<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\SessionHelper;
use App\Helpers\ValidatorHelper;

class UpdatingUserAdminValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        ValidatorHelper::validate(
            SessionHelper::getSessionAttributes(),
            [
                'first_name' => 'string',
                'last_name' => 'string',
                'password' => 'string',
                'email' => "email|unique:users",
                'points' => 'integer',
            ]
        );
    }
}
