<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\BranchController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermission;
use App\Http\Controllers\SearchController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ReportController;




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


// Auth Routes
require __DIR__.'/auth.php';
Route::get('/', function () {
        return redirect(RouteServiceProvider::HOME);

})->middleware('auth');

Route::group(['middleware' => ['auth']], function () {
    Route::get('notification-list', [NotificationsController::class, 'notificationList'])->name('notification.list');
    Route::get('notification-counts', [NotificationsController::class, 'notificationCounts'])->name('notification.counts');
    Route::delete('notification-remove/{id}', [NotificationsController::class, 'notificationRemove'])->name('notification.remove');


});

Route::group(['prefix' => 'app'], function () {

    Route::get('/reports', [ReportController::class, 'index'])->name('backend.reports');

    Route::get('/index_data', [ReportController::class, 'index_data'])->name('backend.reports.index_data');
    Route::delete('/delete/{id}', [ReportController::class, 'DeleteReport'])->name('backend.report.destroy');

    Route::post('/bulk-action', [ReportController::class, 'bulk_action'])->name('backend.reports.bulk_action');



    // Language Switch
    Route::get('language/{language}', [LanguageController::class, 'switch'])->name('language.switch');
    Route::post('set-user-setting', [BackendController::class, 'setUserSetting'])->name('backend.setUserSetting');

    Route::group(['as' => 'backend.', 'middleware' => ['auth']], function () {
        Route::post('update-player-id', [UserController::class, 'update_player_id'])->name('update-player-id');
        Route::get('get_search_data', [SearchController::class, 'get_search_data'])->name('get_search_data');

        // Sync Role & Permission
        Route::group(['middleware' => 'permission:view_permission'], function () {
        Route::get('/permission-role', [RolePermission::class, 'index'])->name('permission-role.list')->middleware('password.confirm');
        Route::post('/permission-role/store/{role_id}', [RolePermission::class, 'store'])->name('permission-role.store');
        Route::get('/permission-role/reset/{role_id}', [RolePermission::class, 'reset_permission'])->name('permission-role.reset');
        // Role & Permissions Crud
        Route::resource('permission', PermissionController::class);
        Route::resource('role', RoleController::class);






    });
    Route::post('send-push-notification', [SettingController::class , 'sendPushNotification'])->name('send-push-notification');


    Route::group(['middleware' => 'permission:view_modules'], function () {
        Route::group(['prefix' => 'module', 'as' => 'module.'], function () {

            Route::get('index_data', [ModuleController::class, 'index_data'])->name('index_data');
            Route::post('update-status/{id}', [ModuleController::class, 'update_status'])->name('update_status');
        });

       Route::resource('module', ModuleController::class);

    });




        /*
          *
          *  Settings Routes
          *
          * ---------------------------------------------------------------------
          */
        Route::group(['middleware' => ['permission:edit_settings']], function () {
            Route::get('settings/{vue_capture?}', [SettingController::class, 'index'])->name('settings')->where('vue_capture', '^(?!storage).*$');
            Route::get('settings-data', [SettingController::class, 'index_data']);
            Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
            Route::post('setting-update', [SettingController::class, 'update'])->name('setting.update');
            Route::get('clear-cache', [SettingController::class, 'clear_cache'])->name('clear-cache');
            Route::get('reload-database', [SettingController::class, 'reload_database'])->name('reload-database');
            Route::post('verify-email', [SettingController::class, 'verify_email'])->name('verify-email');
            Route::get('get-service-price', [SettingController::class, 'get_service_price']);


        });

        /*
        *
        *  Notification Routes
        *
        * ---------------------------------------------------------------------
        */
        Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
            Route::get('/', [NotificationsController::class, 'index'])->name('index');
            Route::get('/markAllAsRead', [NotificationsController::class, 'markAllAsRead'])->name('markAllAsRead');
            Route::delete('/deleteAll', [NotificationsController::class, 'deleteAll'])->name('deleteAll');
            Route::get('/{id}', [NotificationsController::class, 'show'])->name('show');

        });

        /*
        *
        *  Backup Routes
        *
        * ---------------------------------------------------------------------
        */
        Route::group(['prefix' => 'backups', 'as' => 'backups.'], function () {
            Route::get('/', [BackupController::class, 'index'])->name('index');
            Route::get('/create', [BackupController::class, 'create'])->name('create');
            Route::get('/download/{file_name}', [BackupController::class, 'download'])->name('download');
            Route::get('/delete/{file_name}', [BackupController::class, 'delete'])->name('delete');
        });



});



    /*
    *
    * Backend Routes
    * These routes need view-backend permission
    * --------------------------------------------------------------------
    */
    Route::group(['as' => 'backend.', 'middleware' => ['auth']], function () {

        /**
         * Backend Dashboard
         * Namespaces indicate folder structure.
         */
        Route::get('/', [BackendController::class, 'index'])->name('home');

        Route::get('/get_revnue_chart_data/{type}', [BackendController::class, 'getRevenuechartData']);
        Route::get('/get_users_chart_data/{type}', [BackendController::class, 'getUserschart']);
        Route::get('/get_popular_content_chart_data/{type}', [BackendController::class, 'getPopularContentchart']);
        Route::get('/get_subscription_chart_data/{type}', [BackendController::class, 'getSubscriptionchart']);
        Route::get('/get_users_data', [BackendController::class, 'getUserChartData']);
        Route::get('/upgrade_account', [BackendController::class, 'UpgaradeAccount']);





        Route::group(['prefix' => ''], function () {
            Route::get('dashboard', [BackendController::class, 'index'])->name('dashboard');


            /*
            *
            *  Users Routes
            *
            * ---------------------------------------------------------------------
            */
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {

                Route::get('/user-list', [UserController::class, 'user_list'])->name('user_list');
                Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');
                Route::get('/profile/{id}/edit', [UserController::class, 'profileEdit'])->name('profileEdit');
                Route::patch('/profile/{id}/edit', [UserController::class, 'profileUpdate'])->name('profileUpdate');
                Route::get('/emailConfirmationResend/{id}', [UserController::class, 'emailConfirmationResend'])->name('emailConfirmationResend');
                Route::delete('/userProviderDestroy', [UserController::class, 'userProviderDestroy'])->name('userProviderDestroy');
                Route::get('/profile/changeProfilePassword/{id}', [UserController::class, 'changeProfilePassword'])->name('changeProfilePassword');
                Route::patch('/profile/changeProfilePassword/{id}', [UserController::class, 'changeProfilePasswordUpdate'])->name('changeProfilePasswordUpdate');
                Route::get('/changePassword/{id}', [UserController::class, 'changePassword'])->name('changePassword');
                Route::patch('/changePassword/{id}', [UserController::class, 'changePasswordUpdate'])->name('changePasswordUpdate');
                Route::get('/trashed', [UserController::class, 'trashed'])->name('trashed');
                Route::patch('/trashed/{id}', [UserController::class, 'restore'])->name('restore');
                Route::get('customer', [CustomerController::class, 'index'])->name('customer');
                Route::get('/index_data/{role}', [UserController::class, 'index_data'])->name('index_data');
                Route::get('/index_list', [UserController::class, 'index_list'])->name('index_list');
                Route::get('/owner_list', [UserController::class, 'owner_list'])->name('owner_list');
                Route::get('/organizer_list', [UserController::class, 'organizer_list'])->name('organizer_list');
                Route::post('/create-customer', [UserController::class, 'create_customer'])->name('create_customer');
                Route::patch('/{id}/block', [UserController::class, 'block', 'middleware' => ['permission:block_users']])->name('block');
                Route::patch('/{id}/unblock', [UserController::class, 'unblock', 'middleware' => ['permission:block_users']])->name('unblock');
                Route::post('information', [UserController::class, 'updateData'])->name('information');

                Route::post('change-password', [UserController::class, 'change_password'])->name('change_password');
            });
            Route::resource('users', UserController::class);
        });

        Route::get('my-profile/{vue_capture?}', [UserController::class, 'myProfile'])->name('my-profile')->where('vue_capture', '^(?!storage).*$');
        Route::get('my-info', [UserController::class, 'authData'])->name('authData');
    });
});
Route::get('migrate',[LanguageController::class,'migration']);

