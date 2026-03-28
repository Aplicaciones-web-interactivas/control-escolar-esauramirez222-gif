@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-4">Inscripción a Grupos</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($grupos as $grupo)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col justify-between hover:shadow-xl transition">
                
                <div class="bg-blue-800 p-4">
                    <span class="text-xs font-bold text-blue-200 uppercase tracking-widest">{{ $grupo->nombre }}</span>
                    <h3 class="text-xl font-bold text-white leading-tight mt-1">{{ $grupo->horario->materia->nombre }}</h3>
                </div>

                <div class="p-5 space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="font-medium">Prof. {{ $grupo->horario->maestro->name }}</span>
                    </div>

                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">{{ $grupo->horario->dias }}</span>
                    </div>

                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">
                            {{ \Carbon\Carbon::parse($grupo->horario->hora_inicio)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($grupo->horario->hora_fin)->format('H:i') }}
                        </span>
                    </div>
                </div>

                <div class="p-5 bg-gray-50 border-t mt-auto">
                    @if(in_array($grupo->id, $inscritos))
                        <button disabled class="w-full flex justify-center items-center bg-green-100 text-green-700 font-bold py-2 rounded-xl cursor-not-allowed border border-green-300">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Ya estás inscrito
                        </button>
                    @else
                        <form action="{{ route('alumno.inscribir', $grupo->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                                Inscribirme
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white p-10 rounded-2xl shadow text-center">
                <p class="text-gray-500 text-lg">No hay grupos disponibles en este momento.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection