<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['item', 'user_id', 'done', 'completed_on'];

    protected $casts = ['done' => 'bool', "user_id" => 'int'];

    protected $dates = ['completed_on'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*public function showTodo($id)
    {
        $todo = $this->find($id);  
        return $todo;
    }*/

    /*public function updateTodo($data)
    {
        $todo = $this->find($data['id']);
        $todo->user_id = auth()->user()->id;
        $todo->item = $data['item'];        
        return $todo->save();
    }*/

    /*public function deleteTodo($id)
    {
        $todo = $this->find($id);  
        return $todo->delete();
    }*/
}
