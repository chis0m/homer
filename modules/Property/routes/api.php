<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Property\Http\Controllers\RegistrationController;

Route::group(['middleware' => 'throttle:30,1'], function ($route) {

    Route::group(['middleware' =>  ['assign.guard:agents', 'auth:agents'], 'prefix' => 'agent/property'], function ($route) {
        $route->post('create', [RegistrationController::class, 'store']);
        $route->put('update', [RegistrationController::class, 'update']);
        $route->delete('delete/{id}', [RegistrationController::class, 'destroy']);
    });

    Route::group(['middleware' =>  ['assign.guard:admins', 'auth:admins'], 'prefix' => 'admin/property'], function ($route) {
        $route->post('create', [RegistrationController::class, 'store']);
    });

    Route::group(['middleware' => 'jwt.auth'], function ($route){

    });
});
