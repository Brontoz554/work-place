<?php

namespace App\Http\Controllers;

use App\Listt;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'list_id' => 'required|exists:lists,id',
            'description' => 'required',
            'urgency' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors())->setStatusCode('422', 'Validation Errors');
        } else {
            $task = Task::create($request->all());
            return response()->json([
                'task_id' => $task->id
            ])->setStatusCode('201', 'Created');
        }

    }

    public function mark(Task $task)
    {
        $task->mark = 'done';
        $task->save();
        return response()->json([
            'message'=>'успешно завершено',
        ],200);
    }

    public function index()
    {
        return Task::all();
    }

    public function destroy(Task $task)
    {
        if($task->delete()){
            return \response()->json()->setStatusCode(200, "OK");
        } else {
            return \response()->json()->setStatusCode(404, "Not Found");

        }
    }
}
