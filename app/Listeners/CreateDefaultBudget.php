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
        $currentDate = date("Y-m-d");
        $datePlusOneMonth = date('Y-m-d', strtotime('+1 month', strtotime($currentDate)));
        $this->createBudget($event->userId, 'Housing', $currentDate, $datePlusOneMonth, 1000);
        $this->createBudget($event->userId, 'Food', $currentDate, $datePlusOneMonth, 1000);
        $this->createBudget($event->userId, 'Subscriptions', $currentDate, $datePlusOneMonth, 1000);
        $this->createBudget($event->userId, 'Transport', $currentDate, $datePlusOneMonth, 500);
    }
    function createBudget($user_id, $name, $start_date, $end_date, $limit = null)
    {
        Budget::create([
            'user_id' => $user_id,
            'name' => $name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'limit' => $limit,
        ]);
    }
}
