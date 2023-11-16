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
      $share->user_id = $data['user_id'];
      $share->budget_id = $data['budget_id'];
      $share->type = $data['type'];
      $share->save();
    }
    public function getSharedBudget($id)
    {
        $joinedTables = DB::table('budgets')
      ->join('budget_shares', 'budgets.id', '=', 'budget_shares.budget_id')->where('budget_shares.user_id', '=', $id)->get();
    return $joinedTables;
    }
    public function getShared($id)
    {
      $budget = Budget::find($id);
      
    }
}
