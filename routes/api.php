<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;

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

Route::post('/user', [UserController::class, 'signup']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/student', [StudentController::class, 'index']);
Route::get('student/{id}', [StudentController::class, 'show']);


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('student', [StudentController::class, 'store']);
    Route::put('student/{id}', [StudentController::class, 'update']);
    Route::delete('student/{id}', [StudentController::class, 'destroy']);
});