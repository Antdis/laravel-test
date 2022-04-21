<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\BoosterPack
 *
 * @property int                               $id
 * @property float                             $price
 * @property float                             $bank
 * @property int                               $us
 * @property Carbon|null                       $created_at
 * @property Carbon|null                       $updated_at
 * @property-read Collection|BoosterPackInfo[] $boosterPackInfo
 * @property-read int|null                     $booster_pack_info_count
 * @property-read Collection|Item[]            $items
 * @property-read int|null                     $items_count
 * @method static Builder|BoosterPack newModelQuery()
 * @method static Builder|BoosterPack newQuery()
 * @method static Builder|BoosterPack query()
 * @method static Builder|BoosterPack whereBank($value)
 * @method static Builder|BoosterPack whereCreatedAt($value)
 * @method static Builder|BoosterPack whereId($value)
 * @method static Builder|BoosterPack wherePrice($value)
 * @method static Builder|BoosterPack whereUpdatedAt($value)
 * @method static Builder|BoosterPack whereUs($value)
 * @mixin \Eloquent
 */
class BoosterPack extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'bank',
        'us',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, (new BoosterPackInfo)->getTable());
    }

    public function boosterPackInfo(): HasMany
    {
        return $this->hasMany(BoosterPackInfo::class);
    }
}
