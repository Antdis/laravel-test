<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\BoosterPackInfo
 *
 * @property int                   $id
 * @property int                   $booster_pack_id
 * @property int                   $item_id
 * @property Carbon|null           $created_at
 * @property Carbon|null           $updated_at
 * @property-read BoosterPack|null $boosterPack
 * @property-read Item|null        $item
 * @method static Builder|BoosterPackInfo newModelQuery()
 * @method static Builder|BoosterPackInfo newQuery()
 * @method static Builder|BoosterPackInfo query()
 * @method static Builder|BoosterPackInfo whereBoosterPackId($value)
 * @method static Builder|BoosterPackInfo whereCreatedAt($value)
 * @method static Builder|BoosterPackInfo whereId($value)
 * @method static Builder|BoosterPackInfo whereItemId($value)
 * @method static Builder|BoosterPackInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BoosterPackInfo extends Model
{
    protected $table = 'booster_pack_info';

    use HasFactory;

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function boosterPack(): BelongsTo
    {
        return $this->belongsTo(BoosterPack::class);
    }
}
