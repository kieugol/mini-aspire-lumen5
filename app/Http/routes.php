<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$apiPrefix = env('API_PREFIX', 'api/v') . env('API_VERSION', 1);
$namespace = 'App\Http\Controllers';

$app->get('/', function () use ($app) {
    return $app->version();
});

// Management users
$app->group([
    'prefix'    => "$apiPrefix/user",
    'namespace' => $namespace
], function () use ($app) {
    $app->get('/', [
        'uses' => 'UserController@getList',
        'as'   => 'get-list-user'
    ]);
    $app->get('/{id:[0-9]+}', [
        'uses' => 'UserController@getDetail',
        'as'   => 'get-detail-user'
    ]);
    $app->post('/', [
        'uses' => 'UserController@create',
        'as'   => 'create-user'
    ]);
    $app->put('/{id:[0-9]+}', [
        'uses' => 'UserController@update',
        'as'   => 'update-user',
    ]);
    $app->delete('/{id:[0-9]+}', [
        'uses' => 'UserController@delete',
        'as'   => 'delete-user',
    ]);
});
