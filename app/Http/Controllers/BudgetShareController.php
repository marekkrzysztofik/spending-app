<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\BudgetShare;
use App\Models\Budget;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BudgetShareController extends Controller
{
    protected $budgetShare;
    public function __construct()
    {
        $this->budgetShare = new BudgetShare();
    }
    public function shareBudget(Request $data)
    {
      $share = new BudgetShare;
      $share->owner_user_id = $data['owner_user_id'];
      $share->shared_user_id = $data['shared_user_id'];
      $share->budget_id = $data['budget_id'];
      $share->type = $data['type'];
      $share->save();
    }
    public function getSharedBudget($id)
    {
        $joinedTables = DB::table('budgets')
      ->join('budget_shares', 'budgets.id', '=', 'budget_shares.budget_id')->where('budget_shares.shared_user_id', '=', $id)->get();
    return $joinedTables;
    }
    public function getBudgetYouShared($id)
    {
      $joinedTables = DB::table('budgets')
      ->join('budget_shares', 'budgets.id', '=', 'budget_shares.budget_id')->where('budget_shares.owner_user_id', '=', $id)->get();
    return $joinedTables;
    }
}
