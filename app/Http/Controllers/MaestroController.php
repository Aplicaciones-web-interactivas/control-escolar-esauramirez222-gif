<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;

class MaestroController extends Controller
{
    public function misClases()
    {
        // 1. Obtenemos el ID del maestro desde la sesión que tú creaste
        $maestro_id = session('user_id');

        // 2. Traemos los horarios donde este maestro imparte clase
        // Cargamos las relaciones 'materia' y 'grupo' para mostrar nombres
        $horarios = Horario::with(['materia', 'grupo'])
            ->where('usuario_id', $maestro_id)
            ->get();

        return view('maestro.mis_clases', compact('horarios'));
    }

    public function verGrupo($id)
    {
        // Buscamos el grupo y cargamos: Horario -> Materia, y las Inscripciones -> Alumnos
        $grupo = \App\Models\Grupo::with(['horario.materia', 'inscripciones.user'])
            ->whereHas('horario', function($q) {
                $q->where('usuario_id', session('user_id'));
            })
            ->findOrFail($id);

        $tareas = \App\Models\Tarea::where('grupo_id', $id)->latest()->get();

        return view('maestro.detalle_grupo', compact('grupo', 'tareas'));
    }

    public function storeTarea(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_entrega' => 'required|date',
        ]);

        \App\Models\Tarea::create([
            'grupo_id' => $id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_entrega' => $request->fecha_entrega,
        ]);

        return back()->with('success', '¡Tarea publicada con éxito!');
    }

    public function guardarCalificacion(Request $request, $grupo_id, $usuario_id)
    {
        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        \App\Models\Calificacion::updateOrCreate(
            [
                'grupo_id' => $grupo_id,
                'usuario_id' => $usuario_id
            ],
            [
                'calificacion' => $request->calificacion
            ]
        );

        return back()->with('success', 'Calificación guardada correctamente.');
    }

    public function verEntregas($id)
    {
        $tarea = \App\Models\Tarea::with(['grupo.inscripciones.user'])->findOrFail($id);

        $entregas = \App\Models\Entrega::where('tarea_id', $id)->get();

        $entregas_por_alumno = $entregas->keyBy('user_id');

        return view('maestro.entregas', compact('tarea', 'entregas_por_alumno'));
    }

    public function calificarEntrega(Request $request, $id)
    {
        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        $entrega = \App\Models\Entrega::findOrFail($id);
        $entrega->update([
            'calificacion' => $request->calificacion
        ]);

        return back()->with('success', '¡Calificación de la tarea guardada!');
    }
}
