<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'throttle:api'], function ($route) {
    $route->get('/', function () {
        return 'hello world';
    });
});
