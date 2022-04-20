<?php

namespace Database\Seeders;

use App\Models\BoosterPack;
use App\Models\BoosterPackInfo;
use App\Models\Item;
use Illuminate\Database\Seeder;

class BoosterPackSeeder extends Seeder
{
    public function run(): void
    {
        $packs = BoosterPack::query()->get();

        /** @var BoosterPack $pack */
        foreach ($packs as $pack) {
            if (!$pack->items()->count()) {
                $items = Item::query()->inRandomOrder()->take(random_int(5, 8))->get();

                /** @var Item $item */
                foreach ($items as $item) {
                    $info = new BoosterPackInfo();
                    $info->item()->associate($item);
                    $info->boosterPack()->associate($pack);
                    $info->save();

                    dump("Item '$item->name' added to pack #$pack->id");
                }
            } else {
                dump("Pack #$pack->id is not empty");
            }
        }
    }
}
