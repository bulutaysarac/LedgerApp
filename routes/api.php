<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('create-user', [UserController::class, 'createUser']);
Route::post('send-credit-to-user', [UserController::class, 'sendCreditToUser']);
Route::post('get-user-balance', [UserController::class, 'getUserBalance']);
Route::get('get-all-user-balances', [UserController::class, 'getAllUserBalances']);
