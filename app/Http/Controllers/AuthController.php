<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/**
 * AuthController
 * 
 * Controlador encargado de la autenticación y gestión de usuarios.
 * Maneja el registro (con creación simultánea de empresa), login via JWT,
 * obtención del usuario actual, listado de usuarios por empresa,
 * cierre de sesión y creación de usuarios adicionales.
 */
class AuthController extends Controller
{

    /**
     * Registrar un nuevo usuario y su empresa.
     * 
     * Proceso dentro de una transacción:
     * 1. Valida datos del usuario (contraseña segura) y empresa
     * 2. Crea el usuario con contraseña hasheada
     * 3. Crea la empresa asociada al usuario
     * 4. Actualiza el usuario con el company_id
     * 5. Genera un token JWT y lo retorna
     * 
     * Reglas de contraseña: mín 8 chars, mayúscula, minúscula, número, especial
     *
     * @param Request $request Datos del usuario y empresa
     * @return \Illuminate\Http\JsonResponse Usuario creado + token JWT
     */
    public function register(Request $request)
    {
        // Validar datos del usuario y la empresa
        $request->validate([
            'user.name'     => ['required', 'string', 'max:255'],
            'user.email'    => ['required', 'email', 'unique:users,email'],
            'user.password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // al menos una mayúscula
                'regex:/[a-z]/',      // al menos una minúscula
                'regex:/[0-9]/',      // al menos un número
                'regex:/[@$!%*?&#]/', // al menos un carácter especial
            ],
            'company.nameCompany'    => ['required', 'string', 'max:255'],
            'company.razonSocial'    => ['required', 'string', 'max:255'],
            'company.phoneCompany'   => ['required', 'string', 'max:20'],
            'company.emailCompany'   => ['required', 'email'],
            'company.addressCompany' => ['nullable', 'string'],
        ], [
            'user.password.min'   => 'La contraseña debe tener al menos 8 caracteres.',
            'user.password.regex' => 'La contraseña debe incluir mayúscula, minúscula, número y carácter especial (@$!%*?&#).',
            'user.email.unique'   => 'Este email ya está registrado.',
        ]);

        DB::beginTransaction();
        
        try {
            // Crear el usuario con contraseña encriptada
            $user = User::create([
                'name' => $request->user['name'],
                'email' => $request->user['email'],
                'password' => Hash::make($request->user['password']),
            ]);

            // Crear la empresa y asociarla al usuario propietario
            $company = Company::create([
                'name' => $request->company['nameCompany'],
                'razon_social' => $request->company['razonSocial'],
                'phone' => $request->company['phoneCompany'],
                'email' => $request->company['emailCompany'],
                'address' => $request->company['addressCompany'],
                'user_id' => $user->id
            ]);

            // Vincular el usuario con su empresa
            $user->update([
                'company_id' => $company->id
            ]);

            DB::commit();

            // Generar token JWT para iniciar sesión automáticamente
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

    /**
     * Iniciar sesión con email y contraseña.
     * 
     * Intenta autenticar con las credenciales proporcionadas.
     * Si son correctas, retorna un token JWT.
     * Si fallan, retorna error 401.
     *
     * @param Request $request Credenciales (email, password)
     * @return \Illuminate\Http\JsonResponse Token JWT o error
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Intentar autenticación via guard 'api' (JWT)
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ], 401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    /**
     * Obtener los datos del usuario autenticado.
     * 
     * Retorna el modelo User completo del usuario con sesión activa.
     *
     * @return \Illuminate\Http\JsonResponse Datos del usuario
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Listar todos los usuarios de la empresa.
     * 
     * Busca la empresa del usuario autenticado y retorna
     * todos los usuarios que pertenecen a ella (id y nombre).
     *
     * @return \Illuminate\Http\JsonResponse Lista de usuarios
     */
    public function getUsers()
    {
        $company = Company::where('user_id', auth()->id())->first();

        $users = User::select('id', 'name')
            ->where('company_id', $company->id)
            ->get();

        return response()->json($users);
    }

    /**
     * Cerrar sesión.
     * 
     * Elimina la cookie 'token' enviando una cookie vacía con expiración negativa.
     *
     * @return \Illuminate\Http\JsonResponse Mensaje de confirmación
     */
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

    /**
     * Crear un nuevo usuario dentro de la empresa actual.
     * 
     * Valida la contraseña con las mismas reglas de seguridad del registro.
     * El usuario creado se asigna automáticamente a la misma empresa
     * del usuario que lo está creando.
     *
     * @param Request $request Datos del nuevo usuario (nameUser, emailUser, passwordUser)
     * @return \Illuminate\Http\JsonResponse Usuario creado
     */
    public function create(Request $request)
    {
        // Validar datos con reglas de contraseña segura
        $request->validate([
            'nameUser'     => ['required', 'string', 'max:255'],
            'emailUser'    => ['required', 'email', 'unique:users,email'],
            'passwordUser' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // al menos una mayúscula
                'regex:/[a-z]/',      // al menos una minúscula
                'regex:/[0-9]/',      // al menos un número
                'regex:/[@$!%*?&#]/', // al menos un carácter especial
            ],
        ], [
            'passwordUser.min'   => 'La contraseña debe tener al menos 8 caracteres.',
            'passwordUser.regex' => 'La contraseña debe incluir mayúscula, minúscula, número y carácter especial (@$!%*?&#).',
            'emailUser.unique'   => 'Este email ya está registrado.',
        ]);

        // Crear usuario asociado a la empresa del usuario autenticado
        $user = User::create([
            'name' => $request->nameUser,
            'email' => $request->emailUser,
            'password' => Hash::make($request->passwordUser),
            'company_id' => auth()->user()->company_id
        ]);

        return response()->json($user);
    }
}
