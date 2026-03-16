@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 max-w-5xl">
    <div class="py-8">
        
        {{-- Encabezado y botón de crear --}}
        <div class="flex flex-row mb-4 justify-between items-center w-full">
            <h2 class="text-2xl leading-tight font-bold text-gray-800">
                Administración de Materias
            </h2>
            <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Nueva Materia
            </a>
        </div>

        {{-- Tabla de materias --}}
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Clave
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Nombre de la Materia
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Bucle para mostrar las materias --}}
                        @forelse ($materias as $materia)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap font-bold">
                                        {{ $materia->clave }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $materia->nombre }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    {{-- Botón Editar --}}
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4 font-semibold">
                                        Editar
                                    </a>
                                    
                                    {{-- Botón Eliminar --}}
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold" onclick="return confirm('¿Estás seguro de eliminar esta materia?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje si la tabla está vacía --}}
                            <tr>
                                <td colspan="3" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                    No hay materias registradas en el sistema.
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