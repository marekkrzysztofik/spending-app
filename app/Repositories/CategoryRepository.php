<?php

namespace App\Repositories;

use App\Models\Budget;

class CategoryRepository
{
  public function save($category)
  {
    $category->save();
  }
  public function update($category)
  {
    $category->update();
  }
  public function getDataForAnalytics($id, $month, $year)
  {
    $budgets = Budget::with('categories')->where('user_id', '=', $id)->whereMonth('start_date', '=', $month)->whereYear('start_date', '=', $year)->withSum('categories', 'category_limit')->withSum('transactions', 'amount')->get();
    $formattedBudgets = $budgets->map(function ($budget) {
      return [
        'id' => $budget['id'],
        'name' => $budget['name'],
        'user_id' => $budget['user_id'],
        'limit' => $budget['limit'],
        'categories_sum' => $budget['transactions_sum_amount'],

        'labels' => $budget->categories->pluck('category_name')->toArray(),
        'datasets' => [
          [
            'backgroundColor' => ['#41B883'],
            'data' => $budget->categories->pluck('limit')->toArray()
          ],

        ]
      ];
    });
    return $budgets;
  }
}
