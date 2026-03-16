<?php

namespace App\Http\Controllers;

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

    public function createMateria()
    {
        return view('admin.crear_materia'); 
    }

    public function storeMateria(Request $request)
    {
        // Aquí llegará la información cuando el administrador le dé "Guardar" al formulario
        // Validamos y guardamos usando el modelo Materia
    }

    public function createHorario()
    {
        $materias = Materia::all();
        $maestros = User::where('role', 'maestro')->get(); 
        
        return view('admin.crear_horario', compact('materias', 'maestros'));
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
        
        return view('admin.crear_grupo', compact('horarios'));
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

    // Más adelante puedes agregar:
    // public function editMateria($id)   -> Para mostrar el formulario de edición
    // public function updateMateria(...) -> Para actualizar los datos
    // public function destroyMateria($id)-> Para eliminar una materia
}