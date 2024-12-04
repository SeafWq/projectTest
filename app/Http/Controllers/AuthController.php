<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except'=>['login', 'register']]);
    }

    public function login(Request $request) {
        $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);

        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token){
            return response()->json([
               'status'=>'error',
               'message'=> 'Пользователь с такими данными не найден'
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status'=>'success',
            'user'=>$user,
            'authorization'=> [
                'token'=> $token,
                'type'=> 'bearer'
            ]
        ]);
    }

    public function register(Request $request) {
        $request->validate([
            'email'=>'required|string|email',
            'name'=>'required|string|max:64',
            'password'=>'required|string|min:6'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user === null) {
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);

            $token = Auth::login($user);
            return response()->json([
                'status'=>'success',
                'message'=>'Пользователь успешно создан',
                'user'=>$user,
                'authorization'=> [
                    'token'=>$token,
                    'type'=>'bearer'
                ]
            ]);
        }else{
            return response()->json([
                'status'=>'error',
                'message'=>'Пользователь с такой почтой уже существует'
            ], 400);
        }
    }

    public function logout() {
        Auth::logout();
        return response()->json([
            'status'=>'success',
            'message'=>'Вы успешно вышли из аккаунта'
        ]);
    }

    public function refresh() {
        return response()->json([
           'status'=>'success',
           'user'=>Auth::user(),
           'authorization' => [
               'token' => Auth::refresh(),
               'type' => 'bearer'
           ]
        ]);
    }
}
