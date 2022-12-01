<?php

namespace App\Listeners;

use Egal\Core\Events\Event;
use Illuminate\Support\Facades\Hash;

class UpdatingUserHashPasswordListener
{

    public function handle(Event $event): void
    {
        $model = $event->getModel();

        if ($model->isDirty('password')) {
            $model->setAttribute('password', Hash::make($model->getAttribute('password')));
        }
    }

}
