<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clientes')->insert([
            [
                'dni' => '01189877H',
                'correo_electronico' => 'andrea@gmail.com',
                'direccion' => 'Madrid',
                'nombre' => 'Andrea',
                'apellidos' => 'del Vado Puell',
                'telefono' => 666985589,
                'contrasenya' => 'andrea123!',
            ],
            [
                'dni' => '12345678Z',
                'correo_electronico' => 'pablo@gmail.com',
                'direccion' => 'Galicia',
                'nombre' => 'Palbo',
                'apellidos' => 'Vazquez Fernandez',
                'telefono' => 912547896,
                'contrasenya' => 'pablo123!',
            ],
            [
                'dni' => '98745632C',
                'correo_electronico' => 'joaquin@gmail.com',
                'direccion' => 'Córdoba',
                'nombre' => 'Joaquin Ángel',
                'apellidos' => 'Tejero Cañero',
                'telefono' => 689951123,
                'contrasenya' => 'joaquin123!',
            ],
            [
                'dni' => '44556677G',
                'correo_electronico' => 'fulanito@gmail.com',
                'direccion' => 'Asturias',
                'nombre' => 'fulanito',
                'apellidos' => 'García López',
                'telefono' => 673357896,
                'contrasenya' => 'fulanito123!',
            ],
            [
                'dni' => '58236478A',
                'correo_electronico' => 'menganito@gmail.com',
                'direccion' => 'Navarra',
                'nombre' => 'menganito',
                'apellidos' => 'Perez Almansa',
                'telefono' => 915642365,
                'contrasenya' => 'menganito123!',
            ]
        ]);
    }
}
