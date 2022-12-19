<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\SessionHelper;
use App\Helpers\ValidatorHelper;

class UpdatingUserUserValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        ValidatorHelper::validate(
            SessionHelper::getSessionAttributesWithId(),
            [
                'id' => 'owner',
                'first_name' => 'string',
                'last_name' => 'string',
                'email' => "email|unique:users",
                'password' => 'string',
            ]
        );

        $model->setAttribute('points', $model->getOriginal('points'));
    }
}
