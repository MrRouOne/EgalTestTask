<?php

namespace App\Events;

use Egal\Core\Events\Event;
use Egal\Model\Model;

class AbstractEvent extends Event
{
    public function __construct(private Model $model)
    {
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
