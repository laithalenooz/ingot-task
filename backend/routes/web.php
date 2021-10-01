<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::group(['middleware' => 'auth'], function () {
    Route::resources([
        'wallet' => App\Http\Controllers\BalancesController::class,
        'expenses' => App\Http\Controllers\ExpensesController::class,
        'admin'    => App\Http\Controllers\AdminsController::class
    ]);
});
require __DIR__ . '/auth.php';
