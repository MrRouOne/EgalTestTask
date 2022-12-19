<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use Exception;

class DeletingUserAdminValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     * @throws Exception
     */
    public function handle(AbstractEvent $event): void
    {
        if ($event->getModel()->getAttribute('is_admin')) {
            throw new Exception("You cannot delete an administrator account!", 403);
        }
    }
}
