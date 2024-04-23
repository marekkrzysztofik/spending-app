<?php

namespace App\Listeners;
use App\Events\UserCreated;
use App\Models\Budget;
use App\Models\Category;

class CreateDefaultBudget
{
    public function handle(UserCreated $event): void
    {
        $budgetCategoryMap = [
            'Housing' => ['Rent', 500],
            'Food' => ['Groceries', 500],
            'Subscriptions' => ['Streamings', 500],
            'Transport' => ['Fuel', 500]
        ];

        foreach ($budgetCategoryMap as $budgetName => $categoryData) {
            $budgetModel = $this->createBudget($event->userId, $budgetName);
            $this->createCategory($budgetModel->id, $categoryData[0], $categoryData[1]);
        }
    }
    function createBudget($user_id, $name,)
    {
        return Budget::create([
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
