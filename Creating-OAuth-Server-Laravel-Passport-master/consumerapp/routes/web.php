<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;

/**
* Authorization Code grant
*/
Route::get('/', 'AuthorizationCodeGrantController@index');
Route::get('/callback', 'AuthorizationCodeGrantController@callback');
Route::get('/todos', 'AuthorizationCodeGrantController@todos');

/**
* Password grant type GET Request
*/
Route::get('/password', 'PasswordGrantController@index');
Route::get('/password/todos', 'PasswordGrantController@todos');

Route::get('/password/{id}', 'PasswordGrantController@index');
Route::get('/password/todos/{id}', 'PasswordGrantController@show');

/**
* Password grant type POST/PUT/DELETE Request
*/
Route::post('/password', 'PasswordGrantController@store');
Route::put('/password/{id}', 'PasswordGrantController@update');
Route::delete('/password/{id}', 'PasswordGrantController@destroy');

/**
* Implicit grant type GET Request
*/
Route::get('/implicit', 'ImplicitGrantController@index');
Route::get('/implicitCallback', 'ImplicitGrantController@implicitCallback');
Route::get('/implicitList', 'ImplicitGrantController@implicitList');

/**
* Client credentials grant type GET Request
*/
Route::get('/client_credentials', 'ClientCredentialsGrantController@index');
Route::get('/client_credentials/users', 'ClientCredentialsGrantController@users');

Route::get('/client_credentials/{id}', 'ClientCredentialsGrantController@index');
Route::get('/client_credentials/users/{id}', 'ClientCredentialsGrantController@show');