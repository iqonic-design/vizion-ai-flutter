<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\Backend\CustomersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['web', 'auth','permission:view_user']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Customers Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::get('index_list', [CustomersController::class, 'index_list'])->name('index_list');
        Route::get('index_data', [CustomersController::class, 'index_data'])->name('index_data');
        Route::get('trashed', [CustomersController::class, 'trashed'])->name('trashed');
        Route::get('trashed/{id}', [CustomersController::class, 'restore'])->name('restore');
        Route::post('bulk-action', [CustomersController::class, 'bulk_action'])->name('bulk_action');
        Route::post('change-password', [CustomersController::class, 'change_password'])->name('change_password');
        Route::post('update-status/{id}', [CustomersController::class, 'update_status'])->name('update_status');
        Route::post('block-customer/{id}', [CustomersController::class, 'block_customer'])->name('block-customer');
        Route::post('verify-customer/{id}', [CustomersController::class, 'verify_customer'])->name('verify-customer');
        Route::post('/send-push-notification', [CustomersController::class, 'send_push_notification'])->name('send-push-notification');
    });
    Route::resource('customers', CustomersController::class);

    Route::get('users', [CustomersController::class, 'index'])->name('users');
    //Route::get('/customers/{type?}', [CustomersController::class,'index'])->name('customers_all');
    Route::get('/index_data/{type?}', [CustomersController::class, 'index'])->name('paid_plan_expire_user_list');
    Route::post('send-email', [CustomersController::class,'sendEmail'])->name('send.email');
});
