@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <nav class="flex text-gray-500 text-sm mb-2">
                <a href="{{ route('maestro.clases') }}" class="hover:text-blue-600 font-medium">Mis Clases</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-bold">Detalle del Grupo</span>
            </nav>
            <h2 class="text-3xl font-extrabold text-gray-900">{{ $grupo->horario->materia->nombre }}</h2>
            <p class="text-blue-600 font-bold text-lg">{{ $grupo->nombre }}</p>
        </div>
        <a href="{{ route('maestro.clases') }}" class="mt-4 md:mt-0 text-gray-600 hover:text-gray-900 font-bold flex items-center">
            &larr; Volver a Mis Clases
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="font-bold text-gray-700 uppercase tracking-wider text-sm">Lista de Alumnos e Inscritos</h3>
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $grupo->inscripciones->count() }} Alumnos
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-semibold text-gray-500 bg-gray-50 uppercase border-b border-gray-200">
                                <th class="px-6 py-4">Nombre del Alumno</th>
                                <th class="px-6 py-4 text-center">Calificación</th>
                                <th class="px-6 py-4 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($grupo->inscripciones as $inscripcion)
                            <tr class="hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                            {{ substr($inscripcion->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-gray-900 font-medium">{{ $inscripcion->user->name }}</span>
                                    </div>
                                </td>
                                
                                {{-- FORMULARIO DE CALIFICACIÓN --}}
                                <form action="{{ route('maestro.calificar', [$grupo->id, $inscripcion->user->id]) }}" method="POST">
                                    @csrf
                                    <td class="px-6 py-4 text-center">
                                        <input type="number" name="calificacion" step="0.1" min="0" max="10" 
                                            value="{{ \App\Models\Calificacion::where('grupo_id', $grupo->id)->where('usuario_id', $inscripcion->user->id)->first()->calificacion ?? '' }}"
                                            class="w-20 border border-gray-300 rounded-lg p-1 text-center focus:ring-2 focus:ring-blue-600 outline-none" 
                                            placeholder="0.0">
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow transition">
                                            Guardar
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500 italic">No hay alumnos inscritos en este grupo todavía.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-white shadow-xl rounded-2xl p-6 border-t-4 border-blue-600">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Asignar Nueva Tarea</h3>
                <form action="{{ route('maestro.tarea.store', $grupo->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Título</label>
                            <input type="text" name="titulo" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-600 outline-none" placeholder="Nombre de la actividad">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Descripción / Instrucciones</label>
                            <textarea name="descripcion" required rows="3" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-600 outline-none" placeholder="¿Qué deben hacer los alumnos?"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fecha y Hora de Vencimiento</label>
                            <input type="datetime-local" name="fecha_entrega" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-600 outline-none">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                            Publicar Tarea
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Tareas Publicadas</h3>
                <div class="space-y-4">
                    @forelse($tareas as $tarea)
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 shadow-sm relative group">
                            <div class="flex flex-col mb-2">
                                <h4 class="font-bold text-gray-800">{{ $tarea->titulo }}</h4>
                                <span class="text-[10px] mt-1 inline-block bg-red-100 text-red-700 px-2 py-1 rounded-md font-bold w-max">
                                    Vence: {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $tarea->descripcion }}</p>
                            
                            <div class="mt-3 flex items-center text-xs text-blue-600 font-bold hover:underline cursor-pointer">
                                <<a href="{{ route('maestro.tarea.entregas', $tarea->id) }}" class="mt-3 flex items-center text-xs text-blue-600 font-bold hover:underline cursor-pointer">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Ver entregas
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-gray-400 text-sm italic">No has publicado tareas aún.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div> </div> </div>
@endsection