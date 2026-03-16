@extends('layouts.app')

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

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar Grupo
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