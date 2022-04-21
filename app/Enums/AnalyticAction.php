<?php

namespace App\Enums;

enum AnalyticAction: string
{
    case BoosterPack = 'buy boosterpack';
    case Wallet = 'wallet refill';
    case Likes = 'like refill';
}
