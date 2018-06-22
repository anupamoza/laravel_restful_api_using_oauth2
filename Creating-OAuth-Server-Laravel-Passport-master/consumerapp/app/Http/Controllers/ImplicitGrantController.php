<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ImplicitGrantController extends Controller
{
    var $http_build_query;
    var $guzzle_http_client;

    /**
     * Contructor for creating query string.
     *
     * @return http_build_query
     */
    public function __construct()
    {
        $query = http_build_query([
        'client_id' => 6, // Replace with Client ID
        'redirect_uri' => config('app.url').'/implicitCallback?',
        'response_type' => 'token',
        'state' => csrf_token(),
        'scope' => ''
       ]); 
       $this->http_build_query = 'http://192.168.1.94:8000/oauth/authorize?'.$query;
       $this->guzzle_http_client = new Client();
    }

    /**
     * Redirects to URL generated in $http_build_query.
     *
     */
    public function index()
    {
       return redirect($this->http_build_query);
    }

    /**
     * Callback function on successful generation of access_token.
     *
     */
    public function implicitCallback(Request $request)
    { 
        //echo $request->fullUrlWithQuery(['type' => 'anotherstring']);   
        //echo url()->current().(!empty($request->all())?"?":"").http_build_query($request->all());    
        dd($request);
        return redirect('/implicitList?');
    }

     /**
     * Lists Todos
     *
     * @return array 
     */
    public function implicitList(Request $request)
    {
        echo $request->get('access_token');
        session()->put('token', $request->get('access_token')); 
        $response = $this->guzzle_http_client->get('http://192.168.1.94:8000/api/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
        ]);
        return session()->get('token.access_token');
        return json_decode((string) $response->getBody(), true);
    }
}
