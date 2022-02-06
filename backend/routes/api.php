<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\UserController;

use App\Models\User;

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
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
Route::post('email/verification', [AuthController::class, 'emailVerify']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/user', [UserController::class, 'self']);
    // Route::resource('blogs', BlogController::class);
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{id}', [BlogController::class, 'show']);
    Route::post('/blogs', [BlogController::class, 'store'])->middleware('role:'.USER::EDITOR);
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->middleware('role:'.USER::EDITOR);
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->middleware('role:'.USER::ADMIN);
});
