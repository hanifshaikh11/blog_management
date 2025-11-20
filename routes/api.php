<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/blog-create', [BlogController::class, 'store']);
    Route::post('/blog-list', [BlogController::class, 'index']);
    Route::post('/blog-update/{id}', [BlogController::class, 'update']);
    Route::delete('/blog-delete/{id}', [BlogController::class, 'delete']);

    Route::post('/blogs/{id}/like', [BlogController::class, 'blog_like_toggle']);
});