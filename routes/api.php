<?php

use App\Http\Controllers\Api\AbsentController;
use App\Http\Controllers\Api\IntervalController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MemberSpvController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\api\StockController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\StoreLocationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/stores', StoreController::class);
Route::apiResource('/users', UserController::class);
Route::post('/users/login', [UserController::class, 'login'])->name('users.login');
Route::apiResource('/products', ProductController::class);
Route::apiResource('/absents', AbsentController::class);
Route::apiResource('/visits', VisitController::class);
Route::apiResource('/memberspvs', MemberSpvController::class);
Route::apiResource('/locations', LocationController::class);
Route::apiResource('/intervals', IntervalController::class);
Route::apiResource('/storelocations', StoreLocationController::class);
Route::apiResource('/stocks', StockController::class);
