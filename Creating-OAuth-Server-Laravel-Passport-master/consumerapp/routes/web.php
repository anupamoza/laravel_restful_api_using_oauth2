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

/**
Route::get('/', function () {
    return view('welcome');
});
**/

use Illuminate\Http\Request;

/**
* Authorization Code grant
*/
Route::get('/', 'AuthorizationCodeGrantController@index');
Route::get('/callback', 'AuthorizationCodeGrantController@callback');
Route::get('/todos', 'AuthorizationCodeGrantController@todos');

/* // Implicit Grant type
 Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://192.168.1.94:8001/callback',
        'response_type' => 'token', 
        'scope' => '',
    ]);

    return redirect('http://192.168.1.94:8000/oauth/authorize?'.$query);
}); */

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
* Implicit grant type
*/
Route::get('/implicit_redirect', function () {
    $query = http_build_query([
        'client_id' => 6,
        'redirect_uri' => 'http://192.168.1.94:8001/implicit_todos',
        'response_type' => 'token',
        'scope' => '',
    ]);

    return redirect('http://192.168.1.94:8000/oauth/authorize?'.$query);
});

Route::get('/implicit_todos', function (Request $request) {
    $response = (new GuzzleHttp\Client)->post('http://192.168.1.94:8000/oauth/token', [
        'form_params' => [
            //'grant_type' => 'authorization_code',           
            'client_id' => 6, // Replace with Client ID
            //'client_secret' => '11kMJFaiBG2T51uhQcPuIpTBLtyM1fYIEFJWohxk', // Replace with client secret
            'redirect_uri' => 'http://192.168.1.94:8001/implicit_todos',
           // 'code' => $request->code,
        ]
    ]);

    session()->put('token', json_decode((string) $response->getBody(), true));

    return redirect('/implicit_todos_list');
});

Route::get('/implicit_todos_list', function () {
    $response = (new GuzzleHttp\Client)->get('http://192.168.1.94:8000/api/json_response', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
    ]);
    /*echo '<pre>';
    print_r(Session::get('token')); 
    echo session()->get('token.access_token');
    echo '</pre>';
    exit;*/
    echo '<pre>';
    //print_r($response); 
    print_r(json_decode((string) $response->getBody(), true)); 
    echo '</pre>';
    //exit;
    return json_decode((string) $response->getBody(), true);
});


/**
* Client credentials grant type GET Request
*/
Route::get('/client_credentials', 'ClientCredentialsGrantController@index');
Route::get('/client_credentials/users', 'ClientCredentialsGrantController@users');

Route::get('/client_credentials/{id}', 'ClientCredentialsGrantController@index');
Route::get('/client_credentials/users/{id}', 'ClientCredentialsGrantController@show');
