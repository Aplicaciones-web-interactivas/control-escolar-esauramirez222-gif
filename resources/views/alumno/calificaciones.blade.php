@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-4">Mi Boleta de Calificaciones</h2>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h3 class="font-bold text-gray-700 uppercase tracking-wider text-sm">Resumen de Evaluación</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs font-semibold text-gray-500 bg-gray-50 uppercase border-b border-gray-200">
                        <th class="px-6 py-4">Materia</th>
                        <th class="px-6 py-4">Grupo</th>
                        <th class="px-6 py-4">Profesor</th>
                        <th class="px-6 py-4 text-center">Calificación Final</th>
                        <th class="px-6 py-4 text-center">Estatus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($inscripciones as $inscripcion)
                        @php
                            // Buscamos si existe una calificación para este grupo
                            $nota = $calificaciones[$inscripcion->grupo_id] ?? null;
                        @endphp
                        
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $inscripcion->grupo->horario->materia->nombre }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">
                                {{ $inscripcion->grupo->nombre }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">
                                {{ $inscripcion->grupo->horario->maestro->name }}
                            </td>
                            
                            <td class="px-6 py-4 text-center font-bold text-lg">
                                @if(is_null($nota))
                                    <span class="text-gray-400">-</span>
                                @else
                                    {{ number_format($nota, 1) }}
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if(is_null($nota))
                                    <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full">Pendiente</span>
                                @elseif($nota >= 7) {{-- Suponiendo que 7 es la calificación mínima aprobatoria --}}
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">Aprobado</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">Reprobado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                Aún no estás inscrito en ninguna clase. Ve a la sección de Inscripciones.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection