<?php

namespace App\Http\Controllers;

use Auth; // Modelo de Autenticación
use Carbon\Carbon; // Libreria para gestión de fechas
use Illuminate\Http\Request;

// Libreria para cambio de contraseña
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;

use App\Models\User; // Modelo para consultar usuarios

class AuthController extends Controller
{
    // Registro (POST)
    public function register(Request $request)
    {
        // $request->validated();

        // Encriptamos la contraseña
        $encryptPassword = bcrypt($request->password);

        // Adjuntamos los datos para guardar
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'password' => $encryptPassword,
        );

        // Generamos la información para guardado
        $newUser = new User($data);

        // Validando si la info se guarda o no
        if ($newUser->save() == false) {
            // Mensaje de error
            return response()->json(array(
                'message' => "Información no procesada.",
                'data' => $data,
                'code' => 422,
            ), 422);
        }

        // Mensaje de exito
        return response()->json(array(
            'message' => "Ha sido registrado con exito.",
            'data' => $newUser,
            'code' => 201,
        ), 201);
    }

    // Iniciar sesión (POST)
    public function login(Request $request)
    {
        // $request->validated();

        /*
            Verificamos si el usuario existe

            SELECT * FROM users WHERE email = ? LIMIT 1;
        */
        $user = User::where('email', '=', $request->email)
                    ->first();

        // Obtenemos las credenciales
        $credentials = request(array(
            'email', 'password'
        ));

        /*
            Limpiamos los espacios al inicio y final 
            de la contraseña.
        */
        $credentials['password'] = trim($credentials['password']);

        /*
            Verificamos que el usuario exista mientras
            intentamos iniciar sesión
        */
        if (
            Auth::attempt($credentials) == false
            || // Or (O)
            $user == NULL
        ) {
            return response()->json(array(
                'message' => "Usuario no encontrado. Verifique sus credenciales",
                'data' => $user,
                'code' => 401,
            ), 401);
        }

        // Obtenemos el usuario de la sesión iniciada
        $user = $request->user();

        // Definimos el nombre para el token
        $tokenResult = $user->createToken('User Access Token');
        
        // Generamos el token
        $token = $tokenResult->token;

        // Generamos una fecha de vencimiento
        $token->expires_at = Carbon::now()->addHours(2);

        // Guardamos el token
        $token->save();

        $result = array(
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        );

        return response()->json(array(
            'message' => "Bienvenido.",
            'data' => $result,
            'code' => 200,
        ), 200);
    }

    // Cerrar sesión (GET)
    public function logout(Request $request)
    {
        // Obtener el usuario
        $user = $request->user();

        // Obtenemos el token del usuario
        $token = $user->token();

        // Revocamos (Desahabilitar) el token
        $token->revoke();

        return response()->json(array(
            'message' => "Cierre de sesión exitoso.",
            'data' => true,
            'code' => 200,
        ), 200);
    }

    // Perfil (GET)
    public function profile(Request $request)
    {
        // Obtenemos la info del usuario según token
        $user = $request->user();

        return response()->json(array(
            'message' => "Perfil del usuario",
            'data' => $user,
            'code' => 200,
        ), 200);
    }

    // Enviando correo de cambio de contraseña (POST)
    public function sendResetLink(Request $request)
    {
        // $request->validated();

        /* 
            Validando si el correo corresponde a un
            usuario dentro de la aplicación
        */

        // SELECT * FROM users WHERE email = ? LIMIT 1;
        $user = User::where('email', '=', $request->email)
                    ->first();

        // Validando en caso que no este
        if ($user == NULL) {
            return response()->json(array(
                'message' => "Usuario no encontrado. Verifique sus credenciales.",
                'data' => $user,
                'code' => 401,
            ), 401);
        }
        
        // Recuperamos el email de la petición
        $input = $request->only('email');
        
        // Enviando correo de cambio de contraseña
        $send = Password::sendResetLink($input);
        // return $send;
        // return Password::RESET_LINK_SENT;
        // Validar que el correo se envie con exito
        if ($send != Password::RESET_LINK_SENT) {
            return response()->json(array(
                'message' => "No se ha podido enviar el correo de cambio de contraseña.",
                'data' => $user,
                'code' => 400,
            ), 400);
        }

        // Envio de respuesta de exito
        return response()->json(array(
            'message' => "Correo enviado con exito.",
            'data' => $user,
            'code' => 200,
        ), 200);
    }

    // Cambio de contraseña (POST)
    public function resetPassword(Request $request)
    {   
        /*
            email
            token (Se genera al enviar el correo)
            password
            password_confirmation
        */
        // $request->validated();

        // Obtenemos los datos de la petición
        $input = $request->only('email', 'token', 'password', 'password_confirmation');

        // Cambiamos la contraseña según los datos enviados
        $change = Password::reset($input, function ($user, $password) {
            // Forzamos el cambio del usuario
            $user->forceFill(array(
                // Cambiamos la contraseña por una nueva encriptada
                'password' => bcrypt($password),
            ))
            ->save(); //  Guardamos la información una vez modificado

            // Indicamos que el cambio se realizo
            event(new PasswordReset($user));
        }); 

        // Validamos que el cambio se realizo con exito
        if ($change != Password::PASSWORD_RESET) {
            return response()->json(array(
                'message' => "No se logró realizar el cambio de contraseña.",
                'data' => false,
                'code' => 400,
            ), 400);
        }

        return response()->json(array(
            'message' => "Cambio de contraseña realizado con exito.",
            'data' => true,
            'code' => 200,
        ), 200);
    }
}
