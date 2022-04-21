<?php

namespace App\Services;

use App\Enums\AnalyticAction;
use App\Events\UserBalanceChangedEvent;
use App\Exceptions\BoosterPackException;
use App\Models\BoosterPack;
use App\Models\BoosterPackInfo;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BoosterPackService
{
    /**
     * @throws \App\Exceptions\BoosterPackException
     */
    public function open(BoosterPack $boosterPack, User $user): Item
    {
        $maxPrice = $boosterPack->bank + $boosterPack->price - $boosterPack->us;

        /** @var Item $item */
        $item = $boosterPack->items()
            ->where('items.price', '<=', $maxPrice)
            ->inRandomOrder()
            ->first();

        if (!$item) {
            throw new BoosterPackException('Booster pack is empty');
        }

        DB::transaction(function () use ($boosterPack, $user, $item) {
            $boosterPack->bank = $boosterPack->bank + $boosterPack->price - $boosterPack->us - $item->price;
            $boosterPack->save();

            $affected = User::query()
                ->where('id', $user->id)
                ->where('wallet_balance', '>=', $boosterPack->price)
                ->update([
                    'likes_balance'          => DB::raw("likes_balance + $item->price"),
                    'wallet_total_withdrawn' => DB::raw("wallet_total_withdrawn + $boosterPack->price"),
                    'wallet_balance'         => DB::raw("wallet_balance - $boosterPack->price"),
                ]);

            if (!$affected) {
                throw new BoosterPackException('Balance to low');
            }
        });

        $info = BoosterPackInfo::where('item_id', $item->id)
            ->where('booster_pack_id', $boosterPack->id)
            ->first();

        UserBalanceChangedEvent::dispatch($user, $info);

        return $item;
    }
}
