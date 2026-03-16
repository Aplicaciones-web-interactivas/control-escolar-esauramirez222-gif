<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registro()
    {
        return view('registro');
    }

    public function registroGuardar(Request $request)
    {
        
        // Crear un nuevo usuario
        $user = new User();
        $user->name = $request->name;
        $user->clave = $request->clave;
        $user->password = hash::make($request->password);
        $user->save();

        // Redirigir al usuario a la página de inicio de sesión o a otra página
        return redirect()->route('login')->with('success', 'Registro exitoso. Por favor, inicia sesión.');
    }

    public function login()
    {
        return view('login');
    }
    //Forma mas facil de hacer un login, sin usar el sistema de autenticacion de laravel, solo con sesiones
    public function loginPost(Request $request)
    {
        // Validar las credenciales del usuario
        $user = User::where('clave', $request->clave)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); // Iniciar sesión con el usuario autenticado
            // Autenticar al usuario (puedes usar sesiones o tokens)
            // Por ejemplo, usando sesiones:
            session(['user_id' => $user->id]);
            return redirect()->route('welcome')->with('success', 'Inicio de sesión exitoso.');
        } else {
            return back()->withErrors(['message' => 'Credenciales inválidas.']);
        }
    }
}
