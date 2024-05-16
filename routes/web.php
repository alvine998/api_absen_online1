<?php

use App\Http\Controllers\AbsentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IntervalController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MemberSalesController;
use App\Http\Controllers\MemberSpvController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreLocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
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

Route::resource('/user', UserController::class);
Route::resource('/store', StoreController::class);
Route::resource('/visitor', VisitorController::class);
Route::resource('/absent', AbsentController::class);
Route::resource('/product', ProductController::class);
Route::resource('/dashboard', DashboardController::class);
Route::resource('/memberspv', MemberSpvController::class);
Route::resource('/interval', IntervalController::class);
Route::resource('/location', LocationController::class);
Route::resource('/storelocation', StoreLocationController::class);
Route::resource('/stock', StockController::class);
Route::resource('/membersales', MemberSalesController::class);

Route::resource('/', AuthController::class);
Route::post('/login', [AuthController::class, 'login'])->name('welcome.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('welcome.logout');
