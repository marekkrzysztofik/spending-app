<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Budget;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateDefaultBudget
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
 
    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $this->createBudget($event->userId, 'Housing');
        $this->createBudget($event->userId, 'Food');
        $this->createBudget($event->userId, 'Subscriptions');
        $this->createBudget($event->userId, 'Transport');
    }
    function createBudget($user_id, $name)
    {
        Budget::create([
            'user_id' => $user_id,
            'name' => $name,
        ]);
    }
}
