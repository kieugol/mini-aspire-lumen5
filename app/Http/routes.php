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

// User management
$app->group([
    'prefix'    => "$apiPrefix/user",
    'namespace' => $namespace
], function () use ($app) {
    $app->get('/', [
        'uses' => 'UserController@getList',
        'as'   => 'get-list-user'
    ]);
    $app->post('/', [
        'uses' => 'UserController@create',
        'as'   => 'create-user'
    ]);
});

// Loan management
$app->group([
    'prefix'    => "$apiPrefix/loan",
    'namespace' => $namespace
], function () use ($app) {
    $app->get('/', [
        'uses' => 'LoanController@getList',
        'as'   => 'get-list-loan'
    ]);
    $app->get('/by-user/{userId:[0-9]+}', [
        'uses' => 'LoanController@getListByUser',
        'as'   => 'get-list-loan-by-user'
    ]);
    $app->get('/{id:[0-9]+}', [
        'uses' => 'LoanController@getDetail',
        'as'   => 'get-detail-loan'
    ]);
    $app->post('/', [
        'uses' => 'LoanController@create',
        'as'   => 'create-loan'
    ]);
});

// Loan Payment management
$app->group([
    'prefix'    => "$apiPrefix/loan-payment",
    'namespace' => $namespace
], function () use ($app) {
    $app->get('/by-loan/{loanId:[0-9]+}', [
        'uses' => 'LoanPaymentController@getListByLoan',
        'as'   => 'get-list-loan-by-user'
    ]);
    $app->post('/repayment', [
        'uses' => 'LoanPaymentController@repayment',
        'as'   => 'repayment-for-loan'
    ]);
});

// Repayment frequency management
$app->group([
    'prefix'    => "$apiPrefix/repayment-frequency",
    'namespace' => $namespace
], function () use ($app) {
    $app->get('/all', [
        'uses' => 'RepaymentFrequencyController@getAll',
        'as'   => 'get-all-repayment-frequency'
    ]);
});
