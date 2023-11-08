<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\IncomeService;

class IncomeController extends Controller
{
    protected $income;
   private IncomeService $incomeService;

    public function __construct(IncomeService $incomeService)
    {
        $this->incomeService = $incomeService;
    }
    public function createIncome(Request $data)
    {
        $this->incomeService->createIncome($data);
    }
    public function getIncomesByUserId($id, $month)
  {
    return $this->incomeService->getIncomesByUserId($id, $month);
  }
}
