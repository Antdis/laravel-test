<?php

namespace App\Events;

use App\Enums\AnalyticAction;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserBalanceChangedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\User
     */
    public User           $user;
    public Model          $object;
    public AnalyticAction $action;
    public float          $amount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Model $object, AnalyticAction $action, float $amount)
    {
        $this->user   = $user;
        $this->object = $object;
        $this->action = $action;
        $this->amount = $amount;
    }
}
