<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\SessionHelper;

class DeletingUserAssignValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        SessionHelper::checkRole("admin")
            ? (new DeletingUserAdminValidateListener)->handle($event)
            : (new DeletingUserUserValidateListener)->handle($event);
    }
}
