@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-4">Mis Tareas Pendientes</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-8">
        @forelse($tareas as $tarea)
            @php
                // Buscamos si el alumno tiene una entrega registrada para esta tarea en específico
                $mi_entrega = $entregas_realizadas->get($tarea->id);
            @endphp

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300">
                
                <div class="bg-blue-600 p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <span class="text-xs font-bold text-blue-200 uppercase tracking-widest">{{ $tarea->grupo->horario->materia->nombre }}</span>
                        <h3 class="text-2xl font-bold text-white mt-1">{{ $tarea->titulo }}</h3>
                    </div>
                    <span class="bg-white text-red-600 text-xs font-bold px-4 py-2 rounded-full shadow-md">
                        Vence: {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="p-6">
                    <div class="prose max-w-none text-gray-700 mb-8 border-l-4 border-blue-200 pl-4">
                        <p class="whitespace-pre-line">{{ $tarea->descripcion }}</p>
                    </div>

                    @if($mi_entrega)
                        <div class="bg-green-50 border border-green-200 text-green-800 p-5 rounded-xl flex flex-col sm:flex-row items-center justify-between font-bold shadow-sm">
                            <div class="flex items-center mb-4 sm:mb-0">
                                <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <span class="block text-lg">¡Archivo enviado exitosamente!</span>
                                    <span class="text-xs text-green-600 font-medium">Entregado el: {{ $mi_entrega->created_at->format('d/m/Y a las H:i') }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center bg-white px-5 py-3 rounded-xl shadow border border-green-100 min-w-[200px] justify-center">
                                <span class="text-sm text-gray-500 mr-3 tracking-wide uppercase font-semibold">Calificación:</span>
                                @if(is_null($mi_entrega->calificacion))
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1.5 rounded-md font-bold animate-pulse">Pendiente de revisión</span>
                                @else
                                    <span class="text-3xl text-blue-700 font-black leading-none">{{ $mi_entrega->calificacion }}</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <form action="{{ route('alumno.tarea.subir', $tarea->id) }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-400 transition group">
                            @csrf
                            <label class="block text-sm font-extrabold text-gray-700 mb-3 uppercase tracking-wide group-hover:text-blue-600 transition">Sube tu archivo de tarea (Solo PDF)</label>
                            
                            <div class="flex flex-col sm:flex-row items-center gap-4">
                                <input type="file" name="archivo" accept=".pdf" required 
                                    class="flex-1 w-full text-sm text-gray-500 
                                    file:mr-4 file:py-3 file:px-6 
                                    file:rounded-full file:border-0 
                                    file:text-sm file:font-bold 
                                    file:bg-blue-100 file:text-blue-700 
                                    hover:file:bg-blue-200 hover:file:cursor-pointer outline-none transition cursor-pointer">
                                
                                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 whitespace-nowrap">
                                    Enviar Tarea
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white p-12 rounded-3xl shadow-sm text-center border border-gray-100">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Todo al día</h3>
                <p class="text-gray-500 text-lg">¡Yuju! No tienes tareas asignadas por el momento en tus grupos.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection