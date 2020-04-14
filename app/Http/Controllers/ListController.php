<?php

namespace App\Http\Controllers;

use App\Listt;
use App\Task;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ListController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors())->setStatusCode('422', 'Validation Errors');
        } else {
            $list = Listt::create($request->all());
            return response()->json([
                'list_id' => $list->id
            ])->setStatusCode('201', 'Created');
        }

    }

    public function index()
    {
        return Listt::all();
    }

    public function show(Request $request)
    {
        $data = collect([]);
        if ($request->count > 100) {
            $request->count = 10;
            Listt::chunk($request->count, function ($lists) use ($data) {
                $lists->each(function ($item) use ($data) {
                    $data->push($item);
                });
            });

        } else {
            Listt::chunk($request->count, function ($lists) use ($data) {
                $lists->each(function ($item) use ($data) {
                    $data->push($item);
                });
            });
        }

        return response()->json(
            [
                $data,
                $request->count,
            ]
        )->setStatusCode(200, "OK");
    }

    public function destroy(Listt $list)
    {
        if ($list->delete()) {
            return \response()->json()->setStatusCode(200, "OK");
        } else {
            return \response()->json()->setStatusCode(404, "Not Found");

        }
    }

}
