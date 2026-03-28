<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Horario;
use App\Models\Grupo;
use App\Models\User;

class AdminController extends Controller
{
    public function indexMaterias()
    {
        $materias = Materia::all(); 
        return view('admin.materias', compact('materias'));
    }

    // --- CAMBIO 1: Llenamos la función para guardar la materia ---
    public function storeMateria(Request $request)
    {
        // 1. Validamos que no dejen campos vacíos y que la clave no se repita
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:50|unique:materias,clave',
        ]);

        // 2. Guardamos en la base de datos
        Materia::create($request->all());

        // 3. Redirigimos a la tabla de materias con un mensaje de éxito
        return redirect()->route('admin.materias')->with('success', 'Materia creada exitosamente.');
    }

   public function createHorario()
    {
        $materias = Materia::all();
        $maestros = User::where('role', 'maestro')->get(); 
        
        // NUEVO: Traemos todos los horarios creados con los datos de su materia y maestro
        $horarios_creados = Horario::with(['materia', 'maestro'])->get();
        
        // Pasamos la nueva variable a la vista
        return view('admin.crear_horario', compact('materias', 'maestros', 'horarios_creados'));
    }

    public function storeHorario(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'usuario_id' => 'required|exists:users,id',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'dias' => 'required|string',
        ]);

        Horario::create($request->all());
        return redirect()->back()->with('success', 'Horario creado correctamente.');
    }
    
    public function createGrupo()
    {
        $horarios = Horario::with(['materia', 'maestro'])->get();
        
        // NUEVO: Traemos todos los grupos creados con su horario (que a su vez trae la materia y el maestro)
        $grupos_creados = Grupo::with(['horario.materia', 'horario.maestro'])->get();
        
        // Pasamos la nueva variable a la vista
        return view('admin.crear_grupo', compact('horarios', 'grupos_creados'));
    }

    public function storeGrupo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        Grupo::create($request->all());

        return redirect()->back()->with('success', 'Grupo creado correctamente.');
    }

    // Función para actualizar los datos en la base
    public function updateMateria(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:50|unique:materias,clave,' . $id,
        ]);

        $materia = Materia::findOrFail($id);
        $materia->update($request->all());

        return redirect()->route('admin.materias')->with('success', 'Materia actualizada correctamente.');
    }

    // Función para eliminar de la base
    public function destroyMateria($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();

        return redirect()->route('admin.materias')->with('success', 'Materia eliminada correctamente.');
    }

    public function crearMaestro()
    {
        // Traemos a los maestros que ya existen para mostrarlos en una lista
        $maestros = User::where('role', 'maestro')->orderBy('id', 'desc')->get();
        return view('admin.crear_maestro', compact('maestros'));
    }

    public function storeMaestro(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'clave' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Creamos al maestro
        User::create([
            'name' => $request->name,
            'clave' => $request->clave,
            'password' => Hash::make($request->password),
            'role' => 'maestro',
            'active' => true,
        ]);

        return back()->with('success', '¡Profesor registrado exitosamente!');
    }

}