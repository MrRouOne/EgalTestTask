<?php

namespace App\Events;

use App\Models\LotteryGameMatch;
use Egal\Core\Events\Event;

class UpdatedLotteryGameMatchEvent extends Event
{
    private LotteryGameMatch $match;

    public function __construct(LotteryGameMatch $match)
    {
        $this->match = $match;
    }

    public function getModel()
    {
        return $this->match;
    }

}
