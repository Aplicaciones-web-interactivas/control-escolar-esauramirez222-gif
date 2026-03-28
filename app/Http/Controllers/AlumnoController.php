<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inscripcion;
use App\Models\Tarea;
use App\Models\Entrega;

class AlumnoController extends Controller
{
    public function misTareas()
    {
        $alumno_id = Auth::id(); // Obtenemos el ID del alumno logueado

        $grupos_inscritos = Inscripcion::where('user_id', $alumno_id)->pluck('grupo_id');

        $tareas = Tarea::whereIn('grupo_id', $grupos_inscritos)
                        ->with('grupo.horario.materia')
                        ->orderBy('fecha_entrega', 'asc')
                        ->get();

        $entregas_realizadas = Entrega::where('user_id', $alumno_id)->get()->keyBy('tarea_id');

        return view('alumno.mis_tareas', compact('tareas', 'entregas_realizadas'));
    }

    public function subirTarea(Request $request, $tarea_id)
    {
        $request->validate([
            'archivo' => 'required|mimes:pdf|max:2048',
        ]);

        $ruta = $request->file('archivo')->store('entregas', 'public');

        Entrega::create([
            'tarea_id' => $tarea_id,
            'user_id' => Auth::id(),
            'archivo_ruta' => $ruta
        ]);

        return back()->with('success', '¡Tu tarea ha sido entregada con éxito!');
    }

    public function inscripciones()
    {
        $alumno_id = Auth::id();

        $grupos = \App\Models\Grupo::with(['horario.materia', 'horario.maestro'])->get();

        $inscritos = \App\Models\Inscripcion::where('user_id', $alumno_id)
                                            ->pluck('grupo_id')
                                            ->toArray();

        return view('alumno.inscripciones', compact('grupos', 'inscritos'));
    }

    public function inscribir($grupo_id)
    {
        $alumno_id = Auth::id();
        // Validamos que el grupo exista
        $ya_inscrito = \App\Models\Inscripcion::where('user_id', $alumno_id)
                                              ->where('grupo_id', $grupo_id)
                                              ->exists();

        if ($ya_inscrito) {
            return back()->with('error', 'Ya estás inscrito en este grupo.');
        }
        
        \App\Models\Inscripcion::create([
            'grupo_id' => $grupo_id,
            'user_id' => $alumno_id
        ]);

        return back()->with('success', '¡Inscripción exitosa! Ya puedes ver este grupo en tus tareas.');
    }

    public function calificaciones()
    {
        $alumno_id = Auth::id();

        $inscripciones = \App\Models\Inscripcion::where('user_id', $alumno_id)
            ->with(['grupo.horario.materia', 'grupo.horario.maestro'])
            ->get();

        $calificaciones = \App\Models\Calificacion::where('usuario_id', $alumno_id)
            ->pluck('calificacion', 'grupo_id')
            ->toArray();

        return view('alumno.calificaciones', compact('inscripciones', 'calificaciones'));
    }

}