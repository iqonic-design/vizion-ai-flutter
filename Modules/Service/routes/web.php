<?php

use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\Backend\ServicesController;
use Modules\Service\Http\Controllers\Backend\SystemServiceController;

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
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['web', 'auth']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Services Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'services', 'as' => 'services.'],function () {
      Route::get("index_list", [ServicesController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [ServicesController::class, 'index_data'])->name("index_data");
      Route::post('bulk-action', [ServicesController::class, 'bulk_action'])->name('bulk_action');
      Route::get("trashed", [ServicesController::class, 'trashed'])->name("trashed");
      Route::post('update-status/{id}', [ServicesController::class, 'update_status'])->name('update_status');
      Route::patch("trashed/{id}", [ServicesController::class, 'restore'])->name("restore");
    });
    Route::resource("services", ServicesController::class);

    
    Route::group(['prefix' => 'service', 'as' => 'services.'],function () {
      Route::group(['prefix' => '/systemservice', 'as' => 'systemservice.'],function () {
          Route::get('/index_list', [SystemServiceController::class, 'index_list'])->name('index_list');
          Route::get('/index_data', [SystemServiceController::class, 'index_data'])->name('index_data');
          Route::get('/trashed', [SystemServiceController::class, 'trashed'])->name('trashed');
          Route::patch('/trashed/{id}', [SystemServiceController::class, 'restore'])->name('restore');
          Route::post('bulk-action', [SystemServiceController::class, 'bulk_action'])->name('bulk_action');
          Route::post('update-status/{id}', [SystemServiceController::class, 'update_status'])->name('update_status');
    
          Route::get('/index_list_data', [SystemServiceController::class, 'index_list_data'])->name('index_list_data');
      });
      Route::resource('systemservice', SystemServiceController::class);
    });

});


