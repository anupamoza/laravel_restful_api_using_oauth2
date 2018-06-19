<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/todos', function (Request $request) {
        return $request->user()->todos;
});

/*Route::middleware('auth:api')->get('/todos/{id}', 'TodoApiController@Show');
Route::middleware('auth:api')->post('/todos', 'TodoApiController@Store');
Route::middleware('auth:api')->put('/todos/{id}', 'TodoApiController@Update');
Route::middleware('auth:api')->delete('/todos/{id}', 'TodoApiController@Destroy');*/

Route::group(['middleware' => 'auth:api'], function()
{
    Route::resource('todos', 'TodoApiController', ['only' => ['show','store','update','destroy']]);
});

 /*Route::get('/todos', function(Request $request) {
    ...
})->middleware('client');*/

Route::middleware('client')->get('/json_response', function (Request $request) {
        return '{ "name":"John", "age":31, "city":"New York" }';
});