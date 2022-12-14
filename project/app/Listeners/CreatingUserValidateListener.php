<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\ValidatorHelper;

class CreatingUserValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        ValidatorHelper::validate(
            $model->getAttributes(),
            [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string',
            ]
        );

        $model->setAttribute('points', 0);
    }
}
