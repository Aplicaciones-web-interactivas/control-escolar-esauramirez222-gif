@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 max-w-3xl">
    <div class="py-8">
        <h2 class="text-2xl leading-tight font-bold text-gray-800 mb-6">Crear Nuevo Horario</h2>

        {{-- Alerta de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form action="{{ route('admin.horarios.store') }}" method="POST">
                @csrf

                {{-- Selección de Materia --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="materia_id">Materia</label>
                    <select name="materia_id" id="materia_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Selecciona una materia...</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }} ({{ $materia->clave }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Selección de Maestro --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="usuario_id">Maestro</label>
                    <select name="usuario_id" id="usuario_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Selecciona un maestro...</option>
                        @foreach($maestros as $maestro)
                            <option value="{{ $maestro->id }}">{{ $maestro->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Horas --}}
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="hora_inicio">Hora de Inicio</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="hora_fin">Hora de Fin</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                </div>

                {{-- Días --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="dias">Días de la semana</label>
                    <input type="text" name="dias" id="dias" placeholder="Ej. Lunes a Viernes, L-M-V" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar Horario
                    </button>
                    <a href="#" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection