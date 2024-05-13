<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('transactions', TransactionController::class);
Route::get('/deposit', [TransactionController::class, 'showDeposits']);
Route::post('/deposit', [TransactionController::class, 'deposit'])->name('deposit');
Route::get('/withdrawal', [TransactionController::class, 'showWithdrawals'])->name('withdrawal.index');
Route::post('/withdrawal', [TransactionController::class, 'withdraw'])->name('withdrawal');


