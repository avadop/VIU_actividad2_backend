<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordatoriosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('recordatorios')->insert([
            [
                'fecha_inicio' => '2022/03/29',
                'periodicidad' => 365,
                'motivo' => 'RENOVAR VACUNAS',
                'metodo_envio' => 'sms',
                'num_chip' => 7896541,
                'id_clinica' => 123589746
            ],
            [
                'fecha_inicio' => '2022/02/28',
                'periodicidad' => 90,
                'motivo' => 'DESPARASITAR',
                'metodo_envio' => 'sms',
                'num_chip' => 1234567,
                'id_clinica' => 123589746
            ],
            [
                'fecha_inicio' => '2022/08/01',
                'periodicidad' => 365,
                'motivo' => 'RENOVAR VACUNAS',
                'metodo_envio' => 'correo_electronico',
                'num_chip' => 4566981,
                'id_clinica' => 123589746
            ],
            [
                'fecha_inicio' => '2022/10/19',
                'periodicidad' => 365,
                'motivo' => 'RENOVAR VACUNAS',
                'metodo_envio' => 'sms',
                'num_chip' => 6542893,
                'id_clinica' => 123589746
            ],
            [
                'fecha_inicio' => '2022/10/05',
                'periodicidad' => 365,
                'motivo' => 'RENOVAR VACUNAS',
                'metodo_envio' => 'correo_electronico',
                'num_chip' => 6987354,
                'id_clinica' => 123589746
            ]
        ]);
    }
}
