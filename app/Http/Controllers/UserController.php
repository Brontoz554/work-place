<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users|min:6',
            'password' => 'required',
            'repeat_password' => 'required',
            'phone' => 'required|unique:users|min:11',
            'first_name' => 'required|min:2',
            'surname' => 'required|min:2',
        ],
            [
                'unique' => 'Пользователь с такими данными уже существует',
                'required' => 'Поле :attribute является обязательным',
                'min' => 'Поле :attribute должно содержать минимум :min символа(ов)'
            ]);

        if ($validator->fails()) {
            return response()->json($validator->errors())->setStatusCode('422', 'Validation Errors');
        }
        if ($request->password == $request->repeat_password) {
            $user = User::create($request->all());
            return response()->json([
                'user_id' => $user->id
            ])->setStatusCode('201', 'Created');
        } else {
            return response()->json('Пароли должны совпадать')->setStatusCode('422', 'Validation Errors');
        }
    }

    public function index()
    {
        //все поля return User::with('lists')->get();
        //конкеретные поля return User::with('tasks:id,user_id,name')->get();
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
        ],
            [
                'required' => 'Поле :attribute является обязательным',
            ]);

        if ($validator->fails()) {
            return response()->json($validator->errors())->setStatusCode('422', 'Validation Errors');
        }
        if ($user = User::where(['login' => $request->login])->first() and ($request->password == $user->password)) {
            $token = $user->generateToken();
            return response()->json([
                'api_token' => $token,
            ])->setStatusCode('200', 'OK');
        }
        return response()->json([
            'message' => 'Такого пользователя не существует'
        ])->setStatusCode('404', 'Not Found');
    }

    public function logout()
    {
        $user = User::where(['id' => Auth::user()->id])->first();
        $user->api_token = null;
        $user->save();
        return response()->setStatusCode('200', 'OK');
    }

}
