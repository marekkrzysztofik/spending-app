<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Budget;
use App\Models\Category;
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
        $this->createCategory(1, 'Rent', 500);
        $this->createCategory(2, 'Groceries', 500);
        $this->createCategory(3, 'Streamings', 500);
        $this->createCategory(4, 'Fuel', 500);
    }
    function createBudget($user_id, $name,)
    {
        Budget::create([
            'user_id' => $user_id,
            'name' => $name,
        ]);
    }
    function createCategory($budget_id, $name, $limit)
    {
        Category::create([
            'budget_id' => $budget_id,
            'category_name' => $name,
            'category_limit' => $limit
        ]);
    }
}
