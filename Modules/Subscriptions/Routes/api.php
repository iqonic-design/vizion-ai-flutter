<?php
use Illuminate\Support\Facades\Route;
use Modules\Subscriptions\Http\Controllers\Backend\API\PlanController;
use Modules\Subscriptions\Http\Controllers\Backend\API\PlanLimitationController;
use Modules\Subscriptions\Http\Controllers\Backend\API\SubscriptionController;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/save-subscription-details', [SubscriptionController::class, 'saveSubscriptionDetails']);
    Route::get('/user-subscription-history', [SubscriptionController::class, 'getUserSubscriptionHistory']);
    Route::post('/cancel-subscription', [SubscriptionController::class, 'cancelSubscription']);

    Route::apiResource('planlimitation', PlanLimitationController::class);
    Route::apiResource('plans', PlanController::class);

});
?>


