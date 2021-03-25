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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/all','ExampleController@index');
    $router->get('/check-ip-manual','ExampleController@checkIP');
    $router->get('/ip-success','IPController@getIPSuccess');
    $router->get('/ip-fail','IPController@getIPFail');
    $router->get('/ip-info/{ip}','IPController@getIPInfo');
    $router->post('/add-ip','IPController@insertIP');
});
