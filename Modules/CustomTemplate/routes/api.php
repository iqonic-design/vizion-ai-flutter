<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\CustomTemplate\Http\Controllers\Backend\API\CustomTemplatesController;


Route::get('customtemplate-list', [CustomTemplatesController::class, 'CustomTemplateList']);




Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('add-wishlist', [CustomTemplatesController::class, 'addWishListTemplate']);
    Route::get('wishlist-list', [CustomTemplatesController::class, 'WishListTemplateList']);
    Route::get('remove-wishlist/{id}', [CustomTemplatesController::class, 'removeWishListTemplates']);
    

});