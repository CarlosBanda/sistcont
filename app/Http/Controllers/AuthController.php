<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        dump($request->all());
        printf('Registrando usuario: %s', $request->email);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = auth()->login($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email','password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ],401);
        }

        $cookie = cookie('token', $token, 60, '/', null, false, true);

        return response()->json([
            'success' => true
        ])->withCookie($cookie);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        return response()->json([
            'message' => 'Logout'
            ])->cookie(
                'token',
                '',
                -1
            );
    }

}