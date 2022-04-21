<?php

namespace App\Models;

use App\Enums\AnalyticAction;
use App\Enums\AnalyticObject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Analytics
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property string                          $object    String describes the object with which it is carried interaction (boosterpack, wallet, etc)
 * @property string                          $action    Action with object (buy boosterpack, add money to wallet ...)
 * @property int                             $object_id ID with which user interaction
 * @property int                             $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Analytics newModelQuery()
 * @method static Builder|Analytics newQuery()
 * @method static Builder|Analytics query()
 * @method static Builder|Analytics whereAction($value)
 * @method static Builder|Analytics whereAmount($value)
 * @method static Builder|Analytics whereCreatedAt($value)
 * @method static Builder|Analytics whereId($value)
 * @method static Builder|Analytics whereObject($value)
 * @method static Builder|Analytics whereObjectId($value)
 * @method static Builder|Analytics whereUpdatedAt($value)
 * @method static Builder|Analytics whereUserId($value)
 * @mixin \Eloquent
 */
class Analytics extends Model
{
    use HasFactory;

    protected $casts = [
        'action' => AnalyticAction::class,
        'object' => AnalyticObject::class,
    ];
}
