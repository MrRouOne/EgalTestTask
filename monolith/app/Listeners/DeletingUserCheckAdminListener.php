<?php

namespace App\Listeners;

use Egal\Core\Events\Event;

class DeletingUserCheckAdminListener
{

    public function handle(Event $event)
    {
        if ($event->getModel()->getAttribute('is_admin')) {
            throw new \Exception('You cannot delete an administrator account', 403);
       }
    }

}
