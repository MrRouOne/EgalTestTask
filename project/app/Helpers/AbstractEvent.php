<?php

namespace App\Helpers;

use Egal\Core\Events\Event;
use Egal\Model\Model;

class AbstractEvent extends Event
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

}
