<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public $incrementing = false;

    protected $fillable = ['todo_id','todo_name','tode_completed'];
    protected $hidden = ['created_at','updated_at'];

    public function getRouteKeyName(){
        return 'todo_id';
    }
    // public static function Todos()
    //     {
    //         return 'payroll_items';
    //     }
}
