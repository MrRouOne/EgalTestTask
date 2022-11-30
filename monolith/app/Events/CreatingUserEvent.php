<?php

namespace App\Events;

use App\Models\User;
use Egal\Core\Events\Event;

class CreatingUserEvent extends Event
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getModel()
    {
        return $this->user;
    }

}
