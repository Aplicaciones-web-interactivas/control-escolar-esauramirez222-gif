@extends('Layouts.app') 

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 pb-16">
    
    <div class="bg-white shadow-xl rounded-2xl p-8 max-w-md w-full">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-gray-800">Iniciar Sesión</h2>
            <p class="text-gray-500 text-sm mt-2">Ingresa tus credenciales para continuar</p>
        </div>

        {{-- OJO: Cambié route('login') a route('login.post') porque así lo llamaste en tu web.php para la petición POST --}}
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="clave" class="block text-gray-700 font-semibold mb-2 text-sm">Clave Institucional</label>
                <input type="text" name="clave" id="clave" 
                    class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all bg-gray-50 focus:bg-white"
                    placeholder="Escribe tu clave" required>
            </div>
            
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2 text-sm">Contraseña</label>
                <input type="password" name="password" id="password" 
                    class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all bg-gray-50 focus:bg-white"
                    placeholder="••••••••" required>
            </div>
            
            <div class="pt-4">
                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Iniciar Sesión
                </button>
            </div>
        </form>

        @if($errors->any())
            <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">
                            {{ $errors->first() }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection