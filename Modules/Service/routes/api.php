<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\Backend\API\ServiceController;


Route::get('service-list', [ServiceController::class, 'serviceList']);
