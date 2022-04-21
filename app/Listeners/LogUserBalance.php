<?php

namespace App\Listeners;

use App\Enums\AnalyticObject;
use App\Events\UserBalanceChangedEvent;
use App\Models\Analytics;

class LogUserBalance
{
    /**
     * Handle the event.
     *
     * @param \App\Events\UserBalanceChangedEvent $event
     *
     * @return void
     */
    public function handle(UserBalanceChangedEvent $event): void
    {
        $analytics = new Analytics();

        $analytics->user_id   = $event->user->id;
        $analytics->object    = AnalyticObject::fromClass($event->object);
        $analytics->action    = $event->action;
        $analytics->object_id = $event->object->getKey();
        $analytics->amount    = $event->amount;

        $analytics->save();
    }
}
