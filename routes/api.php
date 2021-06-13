<?php

use App\Http\Controllers\API\User\Auth\AuthController as UserAuth;
use App\Http\Controllers\API\Admin\Auth\AuthController as AdminAuth;
use App\Http\Controllers\API\Agent\Auth\AuthController as AgentAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('testing', function () {
    $user = \App\Models\Admin::find(1);
    $data = ['name' => 'tester', 'surname' => 'testing'];
    sendMail($user, 'auth', 'AdminWelcome', $data);
    return 'worked';
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' =>  ['throttle:5,1', 'assign.guard:users']], function ($route) {
    $route->post('/register', [UserAuth::class, 'register']);
    $route->post('/login', [UserAuth::class, 'login']);

    Route::group(['middleware' => ['throttle:45,1', 'jwt.auth']], function ($route) {
        $route->get('/tester', function () {
            return 'hello';
        });
    });
});

Route::group(['middleware' => ['throttle:5,1', 'assign.guard:admins'], 'prefix' => 'admin'], function ($route) {
    $route->post('/register', [AdminAuth::class, 'register']);
    $route->post('/login', [AdminAuth::class, 'login']);
});



Route::group(['middleware' => ['throttle:5,1', 'assign.guard:agents'], 'prefix' => 'agent'], function ($route) {
    $route->post('/register', [AgentAuth::class, 'register']);
    $route->post('/login', [AgentAuth::class, 'login']);
});


Route::get('failed-auth', static function () {
})->name('failed');
