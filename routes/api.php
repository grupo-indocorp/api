<?php

use App\Http\Controllers\Api\ClientController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware(['auth:company', 'check.company'])
    ->group(function () {

        Route::apiResource('clients', ClientController::class);

    });
