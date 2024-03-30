<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\BudgetShareController; 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::get('getCategoriesByBudgetId/{id}', [CategoryController::class, 'getCategoriesByBudgetId']);
Route::get('/getCategories', [CategoryController::class, 'getCategories']);
Route::get('/getCategoryById/{id}', [CategoryController::class, 'getCategoryById']);
Route::post('/createOrUpdateCategory', [CategoryController::class, 'createOrUpdateCategory']);
Route::delete('/deleteCategory/{id}', [CategoryController::class, 'deleteCategory']);



Route::resource('budgets', BudgetController::class); 
Route::get('/getBudgetsForHomePage/{id}', [BudgetController::class, 'getBudgetsForHomePage']); 
Route::get('/getDataForBudgetsComponent/{id}/{month}/{year}', [BudgetController::class, 'getDataForBudgetsComponent']); 
Route::get('/getBudgetsForCategoriesComponent/{id}', [BudgetController::class, 'getBudgetsForCategoriesComponent']); 
Route::get('/getDataForNewTransaction/{id}', [BudgetController::class, 'getDataForNewTransaction']); 
Route::get('getCategoriesForAnalytics/{id}/{month}/{year}', [BudgetController::class, 'getCategoriesForAnalytics']);


Route::get('getDataForHomePage/{id}', [TransactionController::class,   'getDataForHomePage']);
Route::get('getTransactionsJoinedWithCategoriesAndBudgetsByUserId/{id}/{month}/{year}', [TransactionController::class,   'getTransactionsJoinedWithCategoriesAndBudgetsByUserId']);
Route::get('getTransactionsByUserId/{id}/{month}', [TransactionController::class, 'getTransactionsByUserId']);
Route::get('getLastTransactionsByUserId/{id}', [TransactionController::class, 'getLastTransactionsByUserId']);
Route::post('/createTransaction', [TransactionController::class, 'createTransaction']);  

 
Route::get('getUsers', [AuthController::class, 'getUsers']); 
Route::post('register', [AuthController::class, 'register']); 
Route::post('login', [AuthController::class, 'login']);   


Route::get('getIncomesByUserId/{id}/{month}', [IncomeController::class, 'getIncomesByUserId']);
Route::post('createIncome', [IncomeController::class, 'createIncome']); 