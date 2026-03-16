@extends('layouts.app')
@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Iniciar Sesión</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="clave" class="block text-gray-700 font-medium mb-2">Clave</label>
                <input type="text" name="clave" id="clave" class="form-input border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña</label>
                <input type="password" name="password" id="password" class="form-input border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Iniciar Sesión</button>
        </form>
    </div>
@endsection