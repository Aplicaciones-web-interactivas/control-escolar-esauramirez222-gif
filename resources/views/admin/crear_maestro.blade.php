@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-4">Gestión de Profesores</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="bg-white shadow-xl rounded-2xl p-6 border-t-4 border-blue-800 h-fit">
            <h3 class="font-bold text-gray-800 text-lg mb-4">Registrar Nuevo Profesor</h3>
            <form action="{{ route('admin.maestros.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre Completo</label>
                        <input type="text" name="name" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-600 outline-none" placeholder="Ej. Prof. Roberto Gómez">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Clave de Acceso (Usuario)</label>
                        <input type="text" name="clave" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-600 outline-none" placeholder="Ej. PROF001">
                        @error('clave') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Contraseña</label>
                        <input type="password" name="password" required minlength="8" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-600 outline-none" placeholder="Mínimo 8 caracteres">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 mt-4">
                        Registrar
                    </button>
                </div>
            </form>
        </div>

        <div class="md:col-span-2 bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                <h3 class="font-bold text-gray-700 uppercase tracking-wider text-sm">Profesores Activos</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">
                    {{ $maestros->count() }} Registrados
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-semibold text-gray-500 bg-gray-50 uppercase border-b border-gray-200">
                            <th class="px-6 py-4">Nombre</th>
                            <th class="px-6 py-4 text-center">Clave de Acceso</th>
                            <th class="px-6 py-4 text-center">Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($maestros as $maestro)
                            <tr class="hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4 font-medium text-gray-900 flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-800 text-white flex items-center justify-center font-bold mr-3">
                                        {{ substr($maestro->name, 0, 1) }}
                                    </div>
                                    {{ $maestro->name }}
                                </td>
                                <td class="px-6 py-4 text-center font-mono text-sm text-gray-600">
                                    {{ $maestro->clave }}
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ $maestro->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500 italic">No hay profesores registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection