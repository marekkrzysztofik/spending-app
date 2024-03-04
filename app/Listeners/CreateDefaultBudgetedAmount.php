<?php

namespace App\Listeners;

use App\Events\CategoryCreated;
use App\Models\BudgetedAmount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateDefaultBudgetedAmount
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
    public function handle(CategoryCreated $event): void
    {
        $currentDate = date("Y-m-d");
        $this->createBudgetedAmount($event->categoryId, 0, $currentDate);
    }
    function createBudgetedAmount($category_id, $amount, $date)
    {
        BudgetedAmount::create([
            'category_id' => $category_id,
            'amount' => $amount,
            'date' => $date
        ]);
    }
}
