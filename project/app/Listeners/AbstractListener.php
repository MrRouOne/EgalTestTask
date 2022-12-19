<?php

namespace App\Listeners;

use App\Events\AbstractEvent;

class AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
    }
}
