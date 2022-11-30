<?php

namespace App\Listeners;

use Egal\Core\Events\Event;
use App\Helpers\ValidatorHelper;

class CreatingUserValidateListener
{

    public function handle(Event $event): void
    {
        $model = $event->getModel();

        ValidatorHelper::validate($model->getAttributes(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
        ]);

        $model->setAttribute('points', 0);
    }

}
