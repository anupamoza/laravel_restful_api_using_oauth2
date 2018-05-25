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

    Route::get('/', function () {
        $query = http_build_query([
            'client_id' => 3, // Replace with Client ID
            'redirect_uri' => 'http://127.0.0.1:8001/callback',
            'response_type' => 'code',
            'scope' => ''
        ]);
		//echo 'http://127.0.0.1:8000/oauth/authorize?'.$query; exit;
        return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
    });

    Route::get('/callback', function (Request $request) {
        $response = (new GuzzleHttp\Client)->post('http://127.0.0.1:8000/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => 3, // Replace with Client ID
                'client_secret' => '1aOQRDHsTjFqEPvAuLlOkKyYh1Y4XUpxsfe9kDOD', // Replace with client secret
                'redirect_uri' => 'http://127.0.0.1:8001/callback',
                'code' => $request->code,
            ]
        ]);

        session()->put('token', json_decode((string) $response->getBody(), true));

        return redirect('/todos');
    });

    Route::get('/todos', function () {
        $response = (new GuzzleHttp\Client)->get('http://127.0.0.1:8000/api/todos', [
            'headers' => [
                'Authorization' => 'Bearer '.session()->get('token.access_token')
            ]
        ]);

        return json_decode((string) $response->getBody(), true);
    });