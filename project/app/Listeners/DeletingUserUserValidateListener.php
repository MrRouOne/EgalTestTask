<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\ValidatorHelper;

class DeletingUserUserValidateListener extends AbstractListener
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
                'id' => 'required|integer|exists:users,id|owner',
            ]
        );
    }
}
