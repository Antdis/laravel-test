<?php

namespace App\Listeners;

use App\Events\UserBalanceChangedEvent;
use App\Models\BoosterPackInfo;
use App\Services\AnalyticsService;

class LogBoosterPackBuy
{

    public function __construct(private readonly AnalyticsService $analyticsService)
    {
    }

    public function handle(UserBalanceChangedEvent $event): void
    {
        /** @var BoosterPackInfo $object */
        $object = $event->object;

        if (!$object instanceof BoosterPackInfo) {
            return;
        }

        $this->analyticsService->likeLog($event->user, $object->boosterPack, $object->item->price);
        $this->analyticsService->boosterPackLog($event->user, $object->boosterPack, $object->boosterPack->price);
    }
}
