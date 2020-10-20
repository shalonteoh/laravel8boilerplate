<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$api = app('Dingo\Api\Routing\Router');
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

$api->version('v1', function ($api) {
    $api->group([
        'prefix' => 'auth',
        'namespace' => 'App\Http\Controllers\API',
        'middleware' => [
            'api.verify'
        ]
    ], function ($api) {
        $api->post('signup', 'AuthController@signup')->name('auth.signup');
        $api->post('login', 'AuthController@login')->name('auth.login');
    });

    $api->group([
        'namespace' => 'App\Http\Controllers\API',
        'middleware' => ['auth:sanctum']
    ], function ($api) {
        $api->get('user', 'AuthController@getUser');
        $api->get('auth/email/verify', 'AuthController@sendEmailVerification');
    });
});