<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Escolar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    @auth
    <nav class="bg-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <div class="flex items-center">
                    <span class="text-white font-bold text-xl mr-8">
                        Control Escolar
                    </span>

                    <div class="hidden md:flex space-x-2">
                        {{-- 1. MENÚ PARA ADMINISTRADORES --}}
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.materias') }}" class="text-gray-300 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                Materias
                            </a>
                            <a href="{{ route('admin.horarios.create') }}" class="text-gray-300 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                Horarios
                            </a>
                            <a href="{{ route('admin.grupos.create') }}" class="text-gray-300 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                Grupos
                            </a>
                            <a href="{{ route('admin.maestros.crear') }}" class="text-gray-300 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                Profesores
                            </a>

                        {{-- 2. MENÚ PARA MAESTROS --}}
                        @elseif(Auth::user()->role === 'maestro')
                            <a href="{{ route('maestro.clases') }}" class="text-white bg-blue-900 px-3 py-2 rounded-md text-sm font-medium transition">
                                Mis Clases
                            </a>

                        {{-- 3. MENÚ PARA ALUMNOS --}}
                        @else
                            <a href="{{ route('alumno.inscripciones') }}" class="text-gray-300 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                Inscripciones
                            </a>
                            <a href="{{ route('alumno.tareas') }}" class="text-gray-300 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                Mis Tareas
                            </a>
                            <a href="{{ route('alumno.calificaciones') }}" class="text-gray-300 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                Calificaciones
                            </a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-gray-300 text-sm hidden sm:inline-block">
                        <span class="uppercase text-[10px] bg-blue-700 px-2 py-0.5 rounded-full mr-1">{{ Auth::user()->role }}</span>
                        Hola, <span class="font-bold text-white">{{ Auth::user()->name }}</span>
                    </span>
                    
                    <form method="POST" action="{{ route('logout') }}" class="m-0 inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:shadow-lg focus:outline-none">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>
    @endauth

    <main>
        @yield('content')
    </main>

</body>
</html>