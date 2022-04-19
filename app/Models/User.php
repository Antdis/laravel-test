<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int                             $id
 * @property string|null                     $email
 * @property string|null                     $password
 * @property string                          $personaname
 * @property string                          $avatarfull
 * @property int                             $rights
 * @property int                             $likes_balance
 * @property float                           $wallet_balance
 * @property float                           $wallet_total_refilled
 * @property float                           $wallet_total_withdrawn
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatarfull($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLikesBalance($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePersonaname($value)
 * @method static Builder|User whereRights($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereWalletBalance($value)
 * @method static Builder|User whereWalletTotalRefilled($value)
 * @method static Builder|User whereWalletTotalWithdrawn($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'personaname',
        'avatarfull',
        'rights',
        'likes_balance',
        'wallet_balance',
        'wallet_total_refilled',
        'wallet_total_withdrawn',
    ];
}
