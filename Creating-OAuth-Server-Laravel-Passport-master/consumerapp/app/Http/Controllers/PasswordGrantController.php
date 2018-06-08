<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Services\PasswordGrantServices;

class PasswordGrantController extends Controller
{
    var $guzzle_http_client;

    /**
     * Contructor for creating query string.
     *
     * @return http_build_query
     */
    public function __construct(Request $request, PasswordGrantServices $services)
    {
        $this->services = $services;
        $this->request = $request;       
              
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id='')
    {
       return  $this->services->index($id);  
       /* if($id != ''){
        return redirect('/password/todos/'.$id);
        }else{
            return redirect('/password/todos');
        }*/
        
    }


    /**
     * Lists Todos
     *
     * @return array 
     */
    public function todos()
    {
       return $this->services->todos();  
       /*$response = $this->guzzle_http_client->get('http://192.168.1.94:8000/api/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
        ]);       
        return json_decode((string) $response->getBody(), true);*/
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
        return $this->services->store();  

       /* $data = $request->validate(['item' => 'required|between:2,50']);              
        
        $response = $this->guzzle_http_client->post('http://192.168.1.94:8000/api/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'form_params' => [
         'item' => $request->input('item'),
        ],
        ]);        
        return json_decode((string) $response->getBody(), true);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->services->show($id);  
        //echo 'here'; exit;
        /*$response = $this->guzzle_http_client->get('http://192.168.1.94:8000/api/todos/'.$id, [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
        ]);       
        return json_decode((string) $response->getBody(), true);*/
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
        return $this->services->update($id);
        /*$data = $request->validate(['item' => 'required|between:2,50']);            
        $response = $this->guzzle_http_client->put('http://192.168.1.94:8000/api/todos/'.$id, [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'form_params' => [
         'id' => $id,
         'item' => $request->input('item'),
        ],
        ]);        
        return json_decode((string) $response->getBody(), true);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {          
        return $this->services->destroy($id);
        /*$response = $this->guzzle_http_client->delete('http://192.168.1.94:8000/api/todos/'.$id, [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'form_params' => [
         'id' => $id,
        ],
        ]);        
        return json_decode((string) $response->getBody(), true);*/
    }
}
