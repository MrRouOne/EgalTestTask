<?php

namespace App\Listeners;

use Egal\Core\Events\Event;
use Illuminate\Support\Facades\Hash;


class CreatingUserHashPasswordListener
{

    public function handle(Event $event): void
    {
       $event->getModel()->setAttribute('password',Hash::make($event->getModel()->getAttribute('password')));
    }

}
