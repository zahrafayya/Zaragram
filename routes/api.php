<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostmansController;

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

Route::get('p', [PostmansController::class, 'get']);
Route::get('p/{id}', [PostmansController::class, 'get']);
Route::post('p', [PostmansController::class, 'store']);
Route::put('p/{id}', [PostmansController::class, 'update']);
Route::delete('p/{id}', [PostmansController::class, 'destroy']);
