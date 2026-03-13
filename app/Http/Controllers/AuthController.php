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

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ],401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Sesión cerrada']);
    }

}