<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\SessionHelper;

class UpdatingUserAssignValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        SessionHelper::checkRole("admin")
            ? (new UpdatingUserAdminValidateListener)->handle($event)
            : (new UpdatingUserUserValidateListener)->handle($event);
    }
}
