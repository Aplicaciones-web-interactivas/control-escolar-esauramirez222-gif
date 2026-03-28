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
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirigir al usuario a la página de inicio de sesión o a otra página
        return redirect()->route('login')->with('success', 'Registro exitoso. Por favor, inicia sesión.');
    }

    public function login()
    {
        return view('login');
    }

    // Forma mas facil de hacer un login, sin usar el sistema de autenticacion de laravel, solo con sesiones
    public function loginPost(Request $request)
    {
        // Validar las credenciales del usuario
        $user = User::where('clave', $request->clave)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); 
            session(['user_id' => $user->id]);

            // === EL NUEVO SEMÁFORO DE ROLES ===
            if ($user->role === 'admin') {
                // El Admin va a su panel de control total
                return redirect()->route('admin.materias'); 
                
            } elseif ($user->role === 'maestro') {
                // El Maestro irá a su portal (por ahora lo mandamos al welcome en lo que creamos su vista)
                return redirect()->route('maestro.clases');
                
            } else {
                // El Alumno (user) va a su portal
                return redirect()->route('alumno.inscripciones');
            }
            // ==================================

        } else {
            return back()->withErrors(['message' => 'Credenciales inválidas.']);
        }
    }

    // Agregar esto al final de tu AuthController
    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario
        
        $request->session()->invalidate(); // Destruye los datos de la sesión
        $request->session()->regenerateToken(); // Regenera el token de seguridad

        // Lo mandamos de regreso a la pantalla de login
        return redirect()->route('login');
    }
}