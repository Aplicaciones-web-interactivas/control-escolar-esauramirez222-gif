<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Materia;
use App\Models\Horario;
use App\Models\Grupo;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. CREACIÓN DE USUARIOS (ROLES)
        // ==========================================
        
        // 1.1 Administrador (Acceso total)
        User::create([
            'name' => 'Admin Escolar',
            'clave' => 'ADMIN01',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'active' => true,
        ]);

        // 1.2 Maestros (Los que dan clase)
        $maestro1 = User::create([
            'name' => 'Prof. Roberto Gómez',
            'clave' => 'MAE001',
            'password' => Hash::make('12345678'),
            'role' => 'maestro',
            'active' => true,
        ]);

        $maestro2 = User::create([
            'name' => 'Ing. María Curie',
            'clave' => 'MAE002',
            'password' => Hash::make('12345678'),
            'role' => 'maestro',
            'active' => true,
        ]);

        
        // ==========================================
        // 2. CREACIÓN DE MATERIAS
        // ==========================================
        $materia1 = Materia::create([
            'nombre' => 'Matemáticas Discretas',
            'clave' => 'MAT-101'
        ]);

        $materia2 = Materia::create([
            'nombre' => 'Lógica de Programación',
            'clave' => 'PRG-102'
        ]);

        $materia3 = Materia::create([
            'nombre' => 'Sistemas Operativos',
            'clave' => 'SIS-201'
        ]);


        // ==========================================
        // 3. CREACIÓN DE HORARIOS (Relación: Materia + Maestro)
        // ==========================================
        
        // Horario 1: El Prof. Roberto da Matemáticas
        $horario1 = Horario::create([
            'materia_id' => $materia1->id,
            'usuario_id' => $maestro1->id,
            'hora_inicio' => '08:00',
            'hora_fin' => '10:00',
            'dias' => 'Lunes, Miércoles, Viernes',
        ]);

        // Horario 2: La Ing. María da Lógica de Programación
        $horario2 = Horario::create([
            'materia_id' => $materia2->id,
            'usuario_id' => $maestro2->id,
            'hora_inicio' => '10:00',
            'hora_fin' => '12:00',
            'dias' => 'Martes y Jueves',
        ]);

        // Horario 3: El Prof. Roberto también da Sistemas Operativos
        $horario3 = Horario::create([
            'materia_id' => $materia3->id,
            'usuario_id' => $maestro1->id,
            'hora_inicio' => '12:00',
            'hora_fin' => '14:00',
            'dias' => 'Lunes a Viernes',
        ]);


        // ==========================================
        // 4. CREACIÓN DE GRUPOS (Relación: Horario)
        // ==========================================
        Grupo::create([
            'nombre' => 'Grupo A - Matutino',
            'horario_id' => $horario1->id
        ]);

        Grupo::create([
            'nombre' => 'Grupo B - Matutino',
            'horario_id' => $horario2->id
        ]);

        Grupo::create([
            'nombre' => 'Grupo C - Vespertino',
            'horario_id' => $horario3->id
        ]);

        //ALumnos Inscritos a grupos
        $grupos = \App\Models\Grupo::all();

        $grupos = \App\Models\Grupo::all();

        if ($grupos->count() > 0) {
            $contadorGlobal = 1;

            foreach ($grupos as $grupo) {
                for ($i = 1; $i <= 5; $i++) {
                 
                    $alumno = \App\Models\User::create([
                        'name'     => "Alumno " . \Illuminate\Support\Str::random(4),
                        'clave'    => "ALU" . str_pad($contadorGlobal, 4, '0', STR_PAD_LEFT), 
                        'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                        'role'     => 'user', 
                        'active'   => true, 
                    ]);

                    \App\Models\Inscripcion::create([
                        'grupo_id' => $grupo->id,
                        'user_id'  => $alumno->id,
                    ]);

                    $contadorGlobal++;
                }
            }
            $this->command->info("¡Listo! " . ($contadorGlobal - 1) . " alumnos creados con la columna 'clave'.");
        }

    }
}