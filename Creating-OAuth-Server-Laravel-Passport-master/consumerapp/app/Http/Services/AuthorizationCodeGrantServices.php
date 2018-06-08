<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Services\Services;
use App\Http\Repository\PasswordGrantRepository;
use Auth;
use Validator;
use App\User;

class AuthorizationCodeGrantServices extends Services {

	function __construct(AuthorizationCodeGrantRepository $authorizationCodeGrantRepository, Request $request)
	{
			//$this->middleware('auth');
			$this->repository = $authorizationCodeGrantRepository;
			$this->request = $request;
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
         /*return json_encode($request->input('item'));
        return json_encode($request->method());
        return json_encode($_POST);*/
        $data = $this->request->validate(['item' => 'required|between:2,50']);         
        //Auth::user()->todos()->save(new Todo($data));
        $response['data'] = $this->repository->saveTodo($data);
        $response['Successfully Added'] = $response;
        return json_encode($response);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$todo = new Todo();
        //$response = $todo->showTodo($id);
        $response = $this->repository->showTodo($id);
        return json_encode($response);
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
        //$todo = new Todo();
        $data = $this->request->validate(['item' => 'required|between:2,50']); 
        $data['id'] = $id;
        $response = $this->repository->updateTodo($data);
        //$response = $todo->updateTodo($data);
        return response(['status' => $response ? 'success' : 'error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$todo = new Todo();
        //$response = $todo->deleteTodo($id);
        $response = $this->repository->deleteTodo($id);
        return response(['status' => $response ? 'success' : 'error']);
    }


}