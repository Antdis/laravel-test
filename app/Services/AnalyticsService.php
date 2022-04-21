<?php

namespace App\Services;

use App\Enums\AnalyticAction;
use App\Enums\AnalyticObject;
use App\Models\Analytics;
use App\Models\BoosterPack;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AnalyticsService
{
    public function likeLog(User $user, BoosterPack $boosterPack, int $amount): Analytics
    {
        return $this->addLog($user, $boosterPack, $amount, AnalyticAction::Likes);
    }

    public function walletLog(User $user, int $amount): Analytics
    {
        return $this->addLog($user, $user, $amount, AnalyticAction::Wallet);
    }

    public function boosterPackLog(User $user, BoosterPack $boosterPack, int $amount): Analytics
    {
        return $this->addLog($user, $boosterPack, $amount, AnalyticAction::BoosterPack);
    }

    private function addLog(User $user, Model $object, int|float $amount, AnalyticAction $action): Analytics
    {
        $analytics = new Analytics();

        $analytics->user_id   = $user->id;
        $analytics->object    = AnalyticObject::fromClass($object);
        $analytics->action    = $action;
        $analytics->object_id = $object->getKey();
        $analytics->amount    = $amount;

        $analytics->save();

        return $analytics;
    }
}
