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
Route::get('/', function () {
    $query = http_build_query([
        'client_id' => 3, // Replace with Client ID
        'redirect_uri' => 'http://192.168.1.94:8001/callback',
        'response_type' => 'code',
        'scope' => ''
    ]); 
    return redirect('http://192.168.1.94:8000/oauth/authorize?'.$query);
});

Route::get('/callback', function (Request $request) {
    $response = (new GuzzleHttp\Client)->post('http://192.168.1.94:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',           
            'client_id' => 3, // Replace with Client ID
            'client_secret' => '1aOQRDHsTjFqEPvAuLlOkKyYh1Y4XUpxsfe9kDOD', // Replace with client secret
            'redirect_uri' => 'http://192.168.1.94:8001/callback',
            'code' => $request->code,
        ]
    ]);

    session()->put('token', json_decode((string) $response->getBody(), true));

    return redirect('/todos');
});

Route::get('/todos', function () {
    $response = (new GuzzleHttp\Client)->get('http://192.168.1.94:8000/api/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
    ]);

    return json_decode((string) $response->getBody(), true);
});

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
* Password grant type
*/
Route::get('/direct_todos', function (Request $request) {
    $response = (new GuzzleHttp\Client)->post('http://192.168.1.94:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => 5, // Replace with Client ID
            'client_secret' => 'oqtwKUNUjkA0Tn3FabueHqz68age4eNvkq2s3dcx', // Replace with client secret
            'username' => 'anupam.oza@sts.in',
            'password' => '123456',
            'scope' => '',
        ]
    ]);

    session()->put('token', json_decode((string) $response->getBody(), true));
    return redirect('/list_todos');
});

Route::get('/list_todos', function () {
    $response = (new GuzzleHttp\Client)->get('http://192.168.1.94:8000/api/todos', [
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
* Implicit grant type
*/
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 3,
        'redirect_uri' => 'http://192.168.1.94:8001/implicit_todos',
        'response_type' => 'token',
        'scope' => '',
    ]);

    return redirect('http://192.168.1.94:8000/oauth/authorize?'.$query);
});

/*Route::get('/callback2', function (Request $request) {
    $response = (new GuzzleHttp\Client)->post('http://192.168.1.94:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',           
            'client_id' => 3, // Replace with Client ID
            'client_secret' => '1aOQRDHsTjFqEPvAuLlOkKyYh1Y4XUpxsfe9kDOD', // Replace with client secret
            'redirect_uri' => 'http://192.168.1.94:8001/callback',
            'code' => $request->code,
        ]
    ]);

    session()->put('token', json_decode((string) $response->getBody(), true));

    return redirect('/implicit_todos');
});*/

Route::get('/implicit_todos', function () {
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
* Client credentials grant type
*/
Route::get('/client_todo', function (Request $request) {
    $response = (new GuzzleHttp\Client)->post('http://192.168.1.94:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => 3, // Replace with Client ID
            'client_secret' => '1aOQRDHsTjFqEPvAuLlOkKyYh1Y4XUpxsfe9kDOD', // Replace with client secret
        ]
    ]);

    session()->put('token', json_decode((string) $response->getBody(), true));
    /*echo '<pre>';
    print_r(Session::get('token')); 
    echo session()->get('token.access_token');
    echo '</pre>';
    exit;*/
    return redirect('/list_c_todos');
});

Route::get('/list_c_todos', function () {
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