@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-8 border-b pb-4">Mis Clases Asignadas</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($horarios as $horario)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                <div class="bg-blue-600 p-4">
                    <span class="text-xs font-bold text-blue-100 uppercase tracking-widest">Materia</span>
                    <h3 class="text-xl font-bold text-white truncate">{{ $horario->materia->nombre }}</h3>
                    <p class="text-blue-200 text-xs font-medium">{{ $horario->materia->clave }}</p>
                </div>

                <div class="p-5 space-y-4">
                    <div class="flex items-center text-gray-600">
                        <div class="bg-gray-100 p-2 rounded-lg mr-3 text-blue-600 font-bold text-sm">GRUPO</div>
                        <span class="font-bold text-gray-800">
                            {{ $horario->grupo ? $horario->grupo->nombre : 'Pendiente de asignar' }}
                        </span>
                    </div>

                    <div class="flex items-center text-gray-600 text-sm">
                        <span class="font-semibold mr-2 italic">{{ $horario->dias }}</span>
                        <span class="text-blue-600 font-bold">
                            {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                        </span>
                    </div>

                    @if($horario->grupo)
                        <a href="{{ route('maestro.grupo.ver', $horario->grupo->id) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-xl transition duration-200 mt-4 shadow-md">
                            Entrar al Grupo
                        </a>
                    @else
                        <button disabled class="w-full bg-gray-100 text-gray-400 font-bold py-2 rounded-xl cursor-not-allowed mt-4">
                            Grupo no disponible
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-10 rounded-2xl shadow text-center">
                <p class="text-gray-500 text-lg">Aún no tienes materias o grupos asignados.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection