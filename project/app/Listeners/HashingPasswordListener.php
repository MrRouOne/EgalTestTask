<?php

namespace App\Listeners;

use App\Events\AbstractEvent;

class HashingPasswordListener extends AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $hashedPassword = password_hash($model->getAttribute('password'), PASSWORD_DEFAULT);

        if ($model->isDirty('password')) {
            $model->setAttribute('password', $hashedPassword);
        }
    }
}
