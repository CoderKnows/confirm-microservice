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

$router->get('/sendCode', ['as' => 'sendCode', 'uses' =>'ConfirmController@sendCode']);
$router->get('/checkCode', ['as' => 'checkCode', 'uses' =>'ConfirmController@checkCode']);
