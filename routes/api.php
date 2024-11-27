<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileDashboardController;
use App\Http\Controllers\Api\NotificationController;
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

Route::get('about-us', [LoginController::class, 'AboutUs']);
Route::get('privacy-policy', [LoginController::class, 'privacyPolicy']);
Route::get('help-and-support', [LoginController::class, 'helpSupport']);

// routes/api.php
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('refresh', [LoginController::class, 'refresh']);
    Route::post('me', [LoginController::class, 'me']);
    Route::post('change-password', [LoginController::class, 'changePassword']);
    Route::post('set-up-new-password', [LoginController::class, 'SetUpNewPassword']);
   
    //profile dashboard api's
    Route::get('dashboard', [ProfileDashboardController::class, 'dashboard']);
    Route::get('userprofile/completion', [ProfileDashboardController::class, 'getProfileCompletion']);
    Route::put('userprofile/update', [ProfileDashboardController::class, 'updateProfile']);
    Route::post('push-notification-status/update', [ProfileDashboardController::class, 'changePushNotificationStatus']);
    Route::post('email-notification-status/update', [ProfileDashboardController::class, 'changeEmailNotificationStatus']);

    Route::get('notifications', [NotificationController::class, 'index']); // Fetch all notifications
    Route::get('notifications/count', [NotificationController::class, 'notificationCount']); // Fetch all notifications
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']); // Mark as read
    Route::post('notifications/{id}/unread', [NotificationController::class, 'markAsUnread']); // Mark as unread
    Route::post('notifications/read-all', [NotificationController::class, 'markAsReadAll']); // Mark as read
    Route::post('notifications/unread-all', [NotificationController::class, 'markAsUnreadAll']); // Mark as read
});
