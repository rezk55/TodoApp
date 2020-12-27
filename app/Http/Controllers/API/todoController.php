<?php

namespace App\Http\Controllers\API;

use App\Todo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Illuminate\Http\Response;
use Faker\Generator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class todoController extends Controller
{
    //return data and show in route api/todo
    public function index()
    {
        // return response()->json(['status'=>'success','data'=>Todo::all()], 200);
        return response(Todo::all()->jsonSerialize(), Response::HTTP_OK);
    }

   //add data to api and DB
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'todo_id'=>'required',
            'todo_name' => 'required|max:250',
            'todo_completed' => 'required'
        ]);

        if($validation->fails())
        {
            return response(['status'=>'error','errors'=> $validation->errors()],422);
        }

        $todo = new Todo();
        $todo->todo_id = $request->todo_id;
        $todo->todo_name = $request->todo_name;
        $todo->todo_completed = $request->todo_completed;

        if($todo->save())
        {
            return response($todo->jsonSerialize(), Response::HTTP_CREATED);
            // return response()->json(['status'=>'success','data'=>$todo],Response::HTTP_CREATED);
        }
        else
        {
            return response($todo->jsonSerialize(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //get data for specific todo and show in route api/todo/{id}
    public function show($id)
    {
        $todo = DB::table('todos')->where('todo_id',$id)->get();
        if(empty($todo))
        {
            return response($todo->jsonSerialize(), Response::HTTP_NOT_FOUND);
        }
        else
        {
            return response($todo->jsonSerialize(), Response::HTTP_CREATED);
        }
    }

   //edit for specific todo api/todo/{id}
    public function update(Request $request, $id)
    {
        $todo = DB::table('todos')->where('todo_id',$id)->get();

        if(empty($todo))
        {
            return response($todo->jsonSerialize(), Response::HTTP_NOT_FOUND);
        }
        elseif(DB::table('todos')->where('todo_id',$id)->update(
            ['todo_name' => $request->todo_name,
            'todo_completed'=>$request->todo_completed
            ]))
        {
            $todo = DB::table('todos')->where('todo_id',$id)->get();
            return response($todo->jsonSerialize(), Response::HTTP_CREATED);
            // return response()->json(['status'=>'success','data'=>$todo],Response::HTTP_CREATED);
        }
        else
        {
            return response($todo->jsonSerialize(), Response::HTTP_NO_UPDATED_HAPPENED);
        }
    }

    //delete todo api/todo/{todo}
    public function destroy($id)
    {
        $todo = DB::table('todos')->where('todo_id',$id)->get();

        if(empty($todo))
        {
            return response($todo->jsonSerialize(), Response::HTTP_NOT_FOUND);
        }
        elseif(DB::table('todos')->where('todo_id',$id)->delete())
        {
            return response($todo->jsonSerialize(), Response::HTTP_CREATED);
        }
        else
        {
            return response($todo->jsonSerialize(), Response::HTTP_NO_UPDATED_HAPPENED);
        }
    }
}
