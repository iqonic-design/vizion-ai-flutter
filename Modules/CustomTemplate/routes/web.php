<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomTemplate\Http\Controllers\Backend\CustomTemplatesController;

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
     *  Backend CustomTemplates Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'custom-templates', 'as' => 'custom-templates.'],function () {
      Route::get("index_list", [CustomTemplatesController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [CustomTemplatesController::class, 'index_data'])->name("index_data");
      Route::get("trashed", [CustomTemplatesController::class, 'trashed'])->name("trashed");
      Route::post('bulk-action', [CustomTemplatesController::class, 'bulk_action'])->name('bulk_action');
      Route::post('update-status/{id}', [CustomTemplatesController::class, 'update_status'])->name('update_status');
      Route::patch("trashed/{id}", [CustomTemplatesController::class, 'restore'])->name("restore");
    });
    Route::resource("custom-templates", CustomTemplatesController::class);
});

