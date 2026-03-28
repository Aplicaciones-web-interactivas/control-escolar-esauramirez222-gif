@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 max-w-5xl py-8">
    
    <div class="flex flex-row mb-6 justify-between items-center w-full">
        <h2 class="text-2xl font-bold text-gray-800">Crear Nuevo Horario</h2>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 shadow-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-xl p-8 mb-12">
        <form action="{{ route('admin.horarios.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="materia_id" class="block text-sm font-semibold text-gray-700 mb-2">Materia</label>
                    <select name="materia_id" id="materia_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 bg-gray-50 focus:bg-white" required>
                        <option value="" disabled selected>Selecciona una materia...</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }} ({{ $materia->clave }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="usuario_id" class="block text-sm font-semibold text-gray-700 mb-2">Maestro</label>
                    <select name="usuario_id" id="usuario_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 bg-gray-50 focus:bg-white" required>
                        <option value="" disabled selected>Selecciona un maestro...</option>
                        
                        @foreach($maestros as $maestro)
                            <option value="{{ $maestro->id }}">{{ $maestro->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label for="dias" class="block text-sm font-semibold text-gray-700 mb-2">Días de la semana</label>
                    <input type="text" name="dias" id="dias" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 bg-gray-50 focus:bg-white" placeholder="Ej. Lunes a Viernes, L-M-V" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="hora_inicio" class="block text-sm font-semibold text-gray-700 mb-2">Hora Inicio</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 bg-gray-50 focus:bg-white" required>
                    </div>
                    <div>
                        <label for="hora_fin" class="block text-sm font-semibold text-gray-700 mb-2">Hora Fin</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 bg-gray-50 focus:bg-white" required>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                    Guardar Horario
                </button>
            </div>
        </form>
    </div>

    <h3 class="text-xl font-bold text-gray-800 mb-4">Horarios Registrados</h3>
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Materia</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Maestro</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Días</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hora</th>
                </tr>
            </thead>
            <tbody>
                @forelse($horarios_creados as $horario)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <p class="text-gray-900 font-bold whitespace-no-wrap">{{ $horario->materia->nombre ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-xs">{{ $horario->materia->clave ?? '' }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $horario->maestro->name ?? 'N/A' }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $horario->dias }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-200">
                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                            Aún no hay horarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection