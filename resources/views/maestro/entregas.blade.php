@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <nav class="flex text-gray-500 text-sm mb-2">
                <a href="{{ route('maestro.clases') }}" class="hover:text-blue-600 font-medium transition">Mis Clases</a>
                <span class="mx-2">/</span>
                <a href="{{ route('maestro.grupo.ver', $tarea->grupo_id) }}" class="hover:text-blue-600 font-medium transition">Detalle del Grupo</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-bold">Entregas</span>
            </nav>
            <h2 class="text-3xl font-extrabold text-gray-900">{{ $tarea->titulo }}</h2>
            <p class="text-gray-600 mt-1 font-medium">Vence: <span class="text-red-600">{{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y H:i') }}</span></p>
        </div>
        <a href="{{ route('maestro.grupo.ver', $tarea->grupo_id) }}" class="mt-4 md:mt-0 text-gray-600 hover:text-gray-900 font-bold flex items-center transition border border-transparent hover:border-gray-300 px-4 py-2 rounded-lg">
            &larr; Volver al Grupo
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-700 uppercase tracking-wider text-sm">Estado de Entregas y Calificaciones</h3>
            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full shadow-inner">
                {{ $entregas_por_alumno->count() }} de {{ $tarea->grupo->inscripciones->count() }} Entregas
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs font-semibold text-gray-500 bg-gray-50 uppercase border-b border-gray-200">
                        <th class="px-6 py-4">Alumno</th>
                        <th class="px-6 py-4 text-center">Estatus</th>
                        <th class="px-6 py-4 text-center">Fecha de Entrega</th>
                        <th class="px-6 py-4 text-center">Calificación</th>
                        <th class="px-6 py-4 text-center">Archivo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($tarea->grupo->inscripciones as $inscripcion)
                        @php
                            $alumno = $inscripcion->user;
                            // Buscamos si este alumno está en nuestro diccionario de entregas
                            $entrega = $entregas_por_alumno->get($alumno->id);
                        @endphp
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                    {{ substr($alumno->name, 0, 1) }}
                                </div>
                                {{ $alumno->name }}
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($entrega)
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">Entregado</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">Sin entregar</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center text-sm text-gray-600">
                                @if($entrega)
                                    {{ $entrega->created_at->format('d/m/Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($entrega)
                                    <form action="{{ route('maestro.entrega.calificar', $entrega->id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                        @csrf
                                        <input type="number" name="calificacion" step="0.1" min="0" max="10" 
                                            value="{{ $entrega->calificacion }}"
                                            class="w-20 border border-gray-300 rounded-lg p-1.5 text-center focus:ring-2 focus:ring-blue-600 outline-none transition" 
                                            placeholder="0.0">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-3 rounded-lg shadow transition transform hover:-translate-y-0.5">
                                            Guardar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 font-medium">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($entrega)
                                    <a href="{{ asset('storage/' . $entrega->archivo_ruta) }}" target="_blank" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow transition transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Ver PDF
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm italic">Esperando...</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection