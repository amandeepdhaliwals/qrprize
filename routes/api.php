<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileDashboardController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);

// routes/api.php
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('refresh', [LoginController::class, 'refresh']);
    Route::post('me', [LoginController::class, 'me']);
    Route::post('change-password', [LoginController::class, 'changePassword']);
   
    //profile dashboard api's
    Route::get('dashboard', [ProfileDashboardController::class, 'dashboard']);
    Route::get('userprofile/completion', [ProfileDashboardController::class, 'getProfileCompletion']);
    Route::put('userprofile/update', [ProfileDashboardController::class, 'updateProfile']);
});
