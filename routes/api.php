<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\IncomeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getUsers', [AuthController::class, 'getUsers']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::resource('budgets', BudgetController::class);
Route::get('/getBudgetsForHomePage/{userID}', [BudgetController::class, 'getBudgetsForHomePage']);
Route::get('/getDataForBudgetsComponent/{userID}/{month}/{year}', [BudgetController::class, 'getDataForBudgetsComponent']);
Route::get('/getBudgetsForCategoriesComponent/{userID}', [BudgetController::class, 'getBudgetsForCategoriesComponent']);
Route::get('/getDataForNewTransaction/{userID}', [BudgetController::class, 'getDataForNewTransaction']);
Route::get('getCategoriesForAnalytics/{userID}/{month}/{year}', [BudgetController::class, 'getCategoriesForAnalytics']);


Route::get('/getCategories', [CategoryController::class, 'getCategories']);
Route::post('/createOrUpdateCategory', [CategoryController::class, 'createOrUpdateCategory']);
Route::delete('/deleteCategory/{id}', [CategoryController::class, 'deleteCategory']);


Route::get('getTransactionsJoinedWithCategoriesAndBudgetsByUserId/{userID}/{month}/{year}', [TransactionController::class,   'getTransactionsJoinedWithCategoriesAndBudgetsByUserId']);
Route::get('getLastTransactionsByUserId/{userID}', [TransactionController::class, 'getLastTransactionsByUserId']);
Route::post('/createTransaction', [TransactionController::class, 'createTransaction']);


Route::get('getIncomesByUserId/{userID}/{month}', [IncomeController::class, 'getIncomesByUserId']);
Route::post('createIncome', [IncomeController::class, 'createIncome']);
