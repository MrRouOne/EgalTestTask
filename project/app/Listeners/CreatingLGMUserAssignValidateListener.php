<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\SessionHelper;

class CreatingLGMUserAssignValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        SessionHelper::checkRole("admin")
            ? (new CreatingLGMUserAdminValidateListener)->handle($event)
            : (new CreatingLGMUserUserValidateListener)->handle($event);
    }
}
