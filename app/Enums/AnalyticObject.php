<?php

namespace App\Enums;

use App\Models\BoosterPack;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

enum AnalyticObject: string
{
    case BoosterPack = 'boosterpack';
    case User = 'user';

    public static function fromClass(Model $object): self
    {
        return match (get_class($object)) {
            User::class => AnalyticObject::User,
            BoosterPack::class => AnalyticObject::BoosterPack,
            default => throw new \RuntimeException('Wrong class')
        };
    }
}
