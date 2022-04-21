<?php

namespace App\Listeners;

use App\Events\UserBalanceChangedEvent;
use App\Models\User;
use App\Services\AnalyticsService;

class LogUserBalance
{
    public function __construct(private readonly AnalyticsService $analyticsService)
    {
    }

    public function handle(UserBalanceChangedEvent $event): void
    {
        if (!$event->object instanceof User || !$event->amount) {
            return;
        }

        $this->analyticsService->walletLog($event->user, $event->amount);
    }
}
