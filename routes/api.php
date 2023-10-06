<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
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
Route::get('/getBudgetsByUserId/{id}/{month}', [BudgetController::class, 'getBudgetsByUserId']);





Route::get('getTransactionsJoinedWithCategoriesByBudgetId/{id}', [TransactionController::class, 'getTransactionsJoinedWithCategoriesByBudgetId']);
Route::post('/createTransaction', [TransactionController::class, 'createTransaction']);


Route::post('register', [AuthController::class, 'register']); 
Route::post('login', [AuthController::class, 'login']);   