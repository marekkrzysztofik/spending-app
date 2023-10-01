<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
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

Route::get('getCategories', [CategoryController::class, 'getCategories']);
Route::post('/createCategory', [CategoryController::class, 'createCategory']);

Route::post('/createBudget', [BudgetController::class, 'createBudget']);
Route::get('/getBudgetsByUserId/{id}', [BudgetController::class, 'getBudgetsByUserId']);





Route::get('getExpensesJoinedWithCategoriesByMonth/{month}', [ExpenseController::class, 'getExpensesJoinedWithCategoriesByMonth']);
Route::post('/createExpense', [ExpenseController::class, 'createExpense']);


Route::post('register', [AuthController::class, 'register']); 
Route::post('login', [AuthController::class, 'login']);   