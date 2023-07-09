<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('citas')->insert([
            [
                'hora' => '10:00',
                'fecha' => '2023/08/03',
                'modalidad_cita' => 'online',
                'tipo_cita' => 'consulta_general',
                'id_clinica' => 123589746,
                'num_chip' => 1234567
            ],
            [
                'hora' => '16:30',
                'fecha' => '2023/07/29',
                'modalidad_cita' => 'presencial',
                'tipo_cita' => 'vacunacion',
                'id_clinica' => 123589746,
                'num_chip' => 7896541
            ],
            [
                'hora' => '12:00',
                'fecha' => '2023/08/01',
                'modalidad_cita' => 'a_domicilio',
                'tipo_cita' => 'peluqueria',
                'id_clinica' => 123589746,
                'num_chip' => 1122334
            ],
            [
                'hora' => '10:00',
                'fecha' => '2023/07/28',
                'modalidad_cita' => 'presencial',
                'tipo_cita' => 'analitica',
                'id_clinica' => 123589746,
                'num_chip' => 7755689
            ],
            [
                'hora' => '12:00',
                'fecha' => '2023/08/06',
                'modalidad_cita' => 'presencial',
                'tipo_cita' => 'consulta_general',
                'id_clinica' => 123589746,
                'num_chip' => 7755689
            ]
        ]);
    }
}
