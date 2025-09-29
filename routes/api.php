<?php

use App\Http\Controllers\Auth\API\AuthController;
use App\Http\Controllers\Backend\API\BranchController;
use App\Http\Controllers\Backend\API\DashboardController;
use App\Http\Controllers\Backend\API\NotificationsController;
use App\Http\Controllers\Backend\API\SettingController;
use App\Http\Controllers\Backend\API\UserApiController;
use App\Http\Controllers\Backend\API\AddressController;
use App\Http\Controllers\Backend\API\OpenAIController;
use App\Http\Controllers\Backend\API\HistoryController;



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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user-detail', [AuthController::class, 'userDetails']);
Route::get('/user-list', [UserApiController::class, 'user_list'])->name('user_list');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('social-login', 'socialLogin');
    Route::post('forgot-password', 'forgotPassword');
    Route::get('logout', 'logout');
});

Route::get('dashboard-detail', [DashboardController::class, 'dashboardDetail']);
Route::get('firebase-detail', [DashboardController::class, 'firebaseDetails']);
Route::post('chat-completion', [OpenAIController::class, 'ChatCompletion']);




Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::apiResource('user', UserApiController::class);
    Route::apiResource('setting', SettingController::class);
    Route::apiResource('notification', NotificationsController::class);
    Route::get('notification-list', [NotificationsController::class, 'notificationList']);
    Route::get('notification-remove', [NotificationsController::class, 'notificationRemove']);
    Route::get('notification-deleteall', [NotificationsController::class, 'deleteAll']);
    Route::get('search-list', [DashboardController::class, 'searchList']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::post('delete-account', [AuthController::class, 'deleteAccount']);
    Route::get('check-daily-limit', [DashboardController::class, 'CheckDailyLimits']);
    Route::get('check-limits', [DashboardController::class, 'CheckLimits']);
    Route::get('recharge-reminder', [DashboardController::class, 'rechargeReminder']);

    Route::post('save-history', [HistoryController::class, 'saveHistory']);
    Route::get('get-user-history', [HistoryController::class, 'getUserHistory']);
    Route::get('clear-user-history', [HistoryController::class, 'clearUserHistory']);

    Route::post('save-message', [HistoryController::class, 'saveMessage']);
    Route::post('save-recent-chat', [HistoryController::class, 'saveRecentChat']);
    Route::get('recent-chat-list', [HistoryController::class, 'recentChatList']);
    Route::post('edit-recent-chat', [HistoryController::class, 'EditRecentChat']);
    Route::get('delete-recent-chat', [HistoryController::class, 'DeleteRecentChat']);
    Route::get('message-list', [HistoryController::class, 'messageList']);

    Route::post('save-report-or-flag', [HistoryController::class, 'StoreReport']);

    Route::post('upload-image', [HistoryController::class, 'uploadImage']);
    Route::get('get-upload-image', [HistoryController::class, 'getUploadImage']);

});

Route::get('app-configuration', [SettingController::class, 'appConfiguraton']);
