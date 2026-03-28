@extends('Layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 max-w-5xl py-8">
    
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Administración de Materias</h2>

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

    <div class="bg-white shadow-md rounded-xl p-6 mb-10">
        <form action="{{ route('admin.materias.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre de la Materia</label>
                    <input type="text" name="nombre" id="nombre" 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition bg-gray-50 focus:bg-white" 
                        placeholder="Ej. Inteligencia Artificial" required>
                </div>

                <div>
                    <label for="clave" class="block text-sm font-semibold text-gray-700 mb-2">Clave Única</label>
                    <input type="text" name="clave" id="clave" 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition bg-gray-50 focus:bg-white" 
                        placeholder="Ej. IA-401" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                    Guardar Materia
                </button>
            </div>
        </form>
    </div>

    <h3 class="text-xl font-bold text-gray-800 mb-4">Materias Registradas</h3>
    
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
                    @forelse ($materias as $materia)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap font-bold">{{ $materia->clave }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $materia->nombre }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                
                                {{-- Botón Editar (Llama a la función JS pasando los datos) --}}
                                <button type="button" onclick="abrirModal({{ $materia->id }}, '{{ $materia->nombre }}', '{{ $materia->clave }}')" class="text-indigo-600 hover:text-indigo-900 mr-4 font-semibold focus:outline-none">
                                    Editar
                                </button>
                                
                                {{-- Botón Eliminar (Ya conectado a la ruta destroy) --}}
                                <form action="{{ route('admin.materias.destroy', $materia->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold" onclick="return confirm('¿Estás seguro de eliminar la materia {{ $materia->nombre }}?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
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

    <div id="modalEditar" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl p-6 transform transition-all">
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Editar Materia</h3>
                <button type="button" onclick="cerrarModal()" class="text-gray-400 hover:text-red-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="formEditar" method="POST">
                @csrf
                @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit_nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre de la Materia</label>
                        <input type="text" name="nombre" id="edit_nombre" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent bg-gray-50 focus:bg-white" required>
                    </div>
                    <div>
                        <label for="edit_clave" class="block text-sm font-semibold text-gray-700 mb-2">Clave Única</label>
                        <input type="text" name="clave" id="edit_clave" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent bg-gray-50 focus:bg-white" required>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" onclick="cerrarModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                        Actualizar Materia
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<script>
    function abrirModal(id, nombre, clave) {
        // 1. Mostrar el modal quitando la clase 'hidden'
        document.getElementById('modalEditar').classList.remove('hidden');
        
        // 2. Llenar los campos con los datos de la fila que clickeaste
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_clave').value = clave;
        
        // 3. Cambiar la ruta del formulario para que apunte al ID correcto
        document.getElementById('formEditar').action = '/admin/materias/' + id;
    }

    function cerrarModal() {
        // Ocultar el modal poniendo la clase 'hidden'
        document.getElementById('modalEditar').classList.add('hidden');
    }
</script>
@endsection