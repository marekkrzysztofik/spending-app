<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
  public function createIncome(Request $data)
  {
    $income = new Income;
    $income->user_id = $data['user_id'];
    $income->title = $data['title'];
    $income->date = $data['date'];
    $income->amount = $data['amount'];
    $income->save();
  }
  public function getIncomesByUserId($id, $month)
  {
    return Income::where('user_id', '=', $id)->whereMonth('date', '=', $month)->get();
  }
}
 