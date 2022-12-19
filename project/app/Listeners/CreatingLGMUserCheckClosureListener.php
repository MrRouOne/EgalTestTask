<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use Exception;

class CreatingLGMUserCheckClosureListener extends AbstractListener
{
    /**
     * @throws Exception
     */
    public function handle(AbstractEvent $event): void
    {
        $winner = $event->getModel()->match->getAttribute('winner_id');

        if (!is_null($winner)) {
            throw new Exception("The match is already over. The winner is announced.", 400);
        }
    }
}
