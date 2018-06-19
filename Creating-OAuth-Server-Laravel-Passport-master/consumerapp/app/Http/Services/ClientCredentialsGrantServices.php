<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Services\Services;
use App\Http\Repository\ClientCredentialsGrantRepository;
use App\User;

class ClientCredentialsGrantServices extends Services {

	function __construct(ClientCredentialsGrantRepository $clientCredentialsGrantRepository, Request $request) 
	{
			$this->repository = $clientCredentialsGrantRepository;
			$this->request = $request;

            $this->guzzle_http_client = new Client();
            $response = $this->guzzle_http_client->post('http://192.168.1.94:8000/oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => 3, // Replace with Client ID
                'client_secret' => '1aOQRDHsTjFqEPvAuLlOkKyYh1Y4XUpxsfe9kDOD', // Replace with client secret
            ]
            ]);
            session()->put('token', json_decode((string) $response->getBody(), true)); 
	}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id='')
    {        
        if($id != '')
        {
            return redirect('/client/users/'.$id);
        }
        else
        {
            return redirect('/client/users');
        }
        
    }

     /**
     * Lists Todos
     *
     * @return array 
     */
    public function users()
    {
       $response = $this->guzzle_http_client->get('http://192.168.1.94:8000/api/json_response', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
        ]);       
        return json_decode((string) $response->getBody(), true);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = $this->request->validate(['item' => 'required|between:2,50']);              
        
        $response = $this->guzzle_http_client->post('http://192.168.1.94:8000/api/json_response', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'form_params' => [
         'item' => $this->request->input('item'),
        ],
        ]);        
        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //echo 'here'; exit;
        $response = $this->guzzle_http_client->get('http://192.168.1.94:8000/api/json_response/'.$id, [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
        ]);       
        return json_decode((string) $response->getBody(), true);
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
    public function update($id)
    {
        $data = $this->request->validate(['item' => 'required|between:2,50']);            
        $response = $this->guzzle_http_client->put('http://192.168.1.94:8000/api/json_response/'.$id, [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'form_params' => [
         'id' => $id,
         'item' => $this->request->input('item'),
        ],
        ]);        
        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {          
        $response = $this->guzzle_http_client->delete('http://192.168.1.94:8000/api/json_response/'.$id, [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'form_params' => [
         'id' => $id,
        ],
        ]);        
        return json_decode((string) $response->getBody(), true);
    }


}