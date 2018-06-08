<?php

namespace App\Http\Repository;

use App\Http\Repository\Repository;
use App\Todo;
use Auth;
use Exception;

class TodoApiRepository extends Repository 
{
	public function __construct(Todo $todoModel)
    {
        $this->todoModel = $todoModel;        
    }
 
	public function saveTodo($data)
    {
        try{
        	$todo = $this->todoModel;
            $todo->user_id = auth()->user()->id;
            $todo->item = $data['item'];
            if($todo->save()){
                return array('Inserted ID'=>$todo->id);
            }else{
                $error_msg['error_msg'] = 'Data not added';
                return $error_msg;               
            }
        }
        catch(Exception $e){
            $error_msg['error_msg'] = $e->getMessage();
            return $error_msg;
        }
    }

    public function showTodo($id)
    {
        try{
            $todo = $this->todoModel->find($id); 
            return $todo;
        } 
        catch(Exception $e){
            $error_msg['error_msg'] = $e->getMessage();
            return $error_msg;
        }
    }

    public function updateTodo($data)
    {        
        try{
            $todo = $this->todoModel->find($data['id']);
            $todo->user_id = auth()->user()->id;
            $todo->item = $data['item'];
            if($todo->save()){
                return array('Updated ID'=>$data['id']);
            }else{
                $error_msg['error_msg'] = 'Update Failed';
                return $error_msg;               
            }
        }
        catch(Exception $e){
            //$error_msg['error_code'] = $e->errorInfo[1];
            $error_msg['error_msg'] = $e->getMessage();
            return $error_msg;
        }
        
    }

    public function deleteTodo($id)
    {
        $todo = $this->todoModel->find($id);  
        return $todo->delete();
    }
}