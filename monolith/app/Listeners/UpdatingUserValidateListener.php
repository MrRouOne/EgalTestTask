<?php

namespace App\Listeners;

use App\Helpers\ValidatorHelper;
use App\Models\User;
use Egal\Core\Events\Event;
use Egal\Core\Session\Session;

class UpdatingUserValidateListener
{

    public function handle(Event $event): void
    {
        $model = $event->getModel();

        ValidatorHelper::validate($model->getAttributes(), [
            'first_name' => 'string',
            'last_name' => 'string',
            'password' => 'string',
        ]);

        if ($model->isDirty('email')) {
            ValidatorHelper::validate($model->getAttributes(), [
                'email' => "email|unique:users",
            ]);
        }

        if (Session::getUserServiceToken()->getRoles()[0] !== "admin") {
            $model->setAttribute('points', $model->getOriginal('points'));
        }
    }

}
