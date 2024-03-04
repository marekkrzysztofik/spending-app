<?php

namespace App\Http\Controllers;

use App\Models\BudgetedAmount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BudgetedAmountController extends Controller
{
    protected $budgetedAmount;
    public function __construct()
    {
        $this->budgetedAmount = new BudgetedAmount();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $budget = new BudgetedAmount;
        $budget->category_id = $request['category_id'];
        $budget->amount = $request['amount'];
        $budget->date = $request['date'];
        $budget->save();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->budgetedAmount->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetedAmount $budgetedAmount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $budget = BudgetedAmount::find($id);
        $budget->amount = $request['amount'];
        $budget->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetedAmount $budgetedAmount)
    {
        //
    }
}
