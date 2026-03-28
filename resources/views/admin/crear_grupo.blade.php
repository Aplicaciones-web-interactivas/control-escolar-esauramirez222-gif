@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 max-w-3xl">
    <div class="py-8">
        <h2 class="text-2xl leading-tight font-bold text-gray-800 mb-6">Crear Nuevo Grupo</h2>

        {{-- Alerta de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form action="{{ route('admin.grupos.store') }}" method="POST">
                @csrf

                {{-- Nombre del Grupo --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">Nombre o Letra del Grupo</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Ej. 101, A, Sistemas-Matutino" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                {{-- Selección de Horario --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="horario_id">Asignar Horario (Materia y Maestro)</label>
                    <select name="horario_id" id="horario_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Selecciona un horario disponible...</option>
                        @foreach($horarios as $horario)
                            {{-- Aquí mostramos toda la info junta para que sea fácil elegir --}}
                            <option value="{{ $horario->id }}">
                                {{ $horario->materia->nombre ?? 'Sin materia' }} - 
                                Prof. {{ $horario->maestro->nombre ?? 'Sin maestro' }} 
                                ({{ $horario->dias }}, de {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} a {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                        Guardar Grupo
                    </button>
                </div>
            </form>
        </div>
        <div class="mt-12">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Grupos Registrados</h3>
            
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre del Grupo</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Materia Asignada</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Maestro</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Días y Horario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grupos_creados as $grupo)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 font-bold whitespace-no-wrap text-lg">{{ $grupo->nombre }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $grupo->horario->materia->nombre ?? 'N/A' }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $grupo->horario->maestro->name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $grupo->horario->dias ?? 'N/A' }}</p>
                                    <p class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($grupo->horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($grupo->horario->hora_fin)->format('H:i') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                    Aún no hay grupos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection