<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        DB::beginTransaction();
        // print_r($request->user);
        // return $request->all();
        try {
            // crear user
            $user = User::create([
                'name' => $request->user['name'],
                'email' => $request->user['email'],
                'password' => Hash::make($request->user['password']),
            ]);

            // crear company
            $company = $user->company()->create([
                'name' => $request->company['nameCompany'],
                'razon_social' => $request->company['razonSocial'],
                'phone' => $request->company['phoneCompany'],
                'email' => $request->company['emailCompany'],
                'address' => $request->company['addressCompany'],
            ]);

            DB::commit();

            $token = auth('api')->login($user);

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => 'Error al registrarse',
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function login(Request $request)
    {

        $credentials = $request->only('email','password');

        if (!$token = auth('api')->attempt($credentials)) {
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
        return response()->json([
            'message' => 'Logout'
            ])->cookie(
                'token',
                '',
                -1
            );
    }

}