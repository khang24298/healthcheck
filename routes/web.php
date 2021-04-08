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

$router->get('/','IPController@index');

$router->get('/upload', function (){
    return view('upload');
});
$router->get('/supervisors','SupervisorController@index');
$router->group(['prefix' => 'api'], function () use ($router) {
    // IPController
    $router->get('/check-ip-manual','IPController@checkIP');
    $router->get('/ip-success','IPController@getIPSuccess');
    $router->get('/ip-fail','IPController@getIPFail');
    $router->get('/ip-info/{ip}','IPController@getIPInfo');
    $router->post('/add-ip','IPController@insertIP');
    $router->get('/test-ip','IPController@testIP');
    // SupervisorController
    $router->get('/supervisor/{id}','SupervisorController@runSupervisor');
    $router->get('/supervisor-edit/{id}','SupervisorController@show');
    $router->post('/supervisor','SupervisorController@store');
    $router->post('/supervisor-edit','SupervisorController@update');
    $router->delete('/supervisor/{id}','SupervisorController@delete');

});
