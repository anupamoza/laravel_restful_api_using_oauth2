<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Services\Services;
use App\Http\Repository\PasswordGrantRepository;
use App\User;

class PasswordGrantServices extends Services {

	function __construct(PasswordGrantRepository $passwordGrantRepository, Request $request) 
	{
			$this->repository = $passwordGrantRepository;
			$this->request = $request;

            $this->guzzle_http_client = new Client();
            $response = $this->guzzle_http_client->post('http://192.168.1.94:8000/oauth/token', [
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
            return redirect('/password/todos/'.$id);
        }
        else
        {
            return redirect('/password/todos');
        }
        
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = $this->request->validate(['item' => 'required|between:2,50']);              
        
        $response = $this->guzzle_http_client->post('http://192.168.1.94:8000/api/todos', [
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
        $response = $this->guzzle_http_client->get('http://192.168.1.94:8000/api/todos/'.$id, [
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
        $response = $this->guzzle_http_client->put('http://192.168.1.94:8000/api/todos/'.$id, [
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
        $response = $this->guzzle_http_client->delete('http://192.168.1.94:8000/api/todos/'.$id, [
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