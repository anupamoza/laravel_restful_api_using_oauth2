<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthorizationCodeGrantController extends Controller
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
        'client_id' => 3, // Replace with Client ID
        'redirect_uri' => config('app.url').'/callback',
        'response_type' => 'code',
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
    public function callback(Request $request)
    {
        $response = $this->guzzle_http_client->post('http://192.168.1.94:8000/oauth/token', [
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
    }

    /**
     * Lists Todos
     *
     * @return array 
     */
    public function todos()
    {
        $response = $this->guzzle_http_client->get('http://192.168.1.94:8000/api/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return 'here';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
