<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;
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
            $company = Company::create([
                'name' => $request->company['nameCompany'],
                'razon_social' => $request->company['razonSocial'],
                'phone' => $request->company['phoneCompany'],
                'email' => $request->company['emailCompany'],
                'address' => $request->company['addressCompany'],
                'user_id' => $user->id
            ]);

            $user->update([
                'company_id' => $company->id
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

    public function getUsers(){
        $company = Company::where('user_id',auth()->id())->first();

        $users = User::select('id','name')->where('company_id', $company->id)->get();
        return response()->json($users);
        // return User::select('id','name')->get();
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

    public function create(Request $request){
        // return auth()->user()->company_id;
        $user = User::create([
            'name' => $request->nameUser,
            'email' => $request->emailUser,
            'password' => Hash::make($request->passwordUser),
            'company_id' => auth()->user()->company_id
        ]);

        return response()->json($user);
    }

}