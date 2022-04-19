<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BoosterPack
 *
 * @property int                             $id
 * @property float                           $price
 * @property float                           $bank
 * @property int                             $us
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
}
