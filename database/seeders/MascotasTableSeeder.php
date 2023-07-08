<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MascotasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mascotas')->insert([
            [
                'num_chip' => 1234567,
                'nombre_mascota' => 'Darwin',
                'edad' => 2,
                'sexo' => 'H',
                'especie' => 'gato',
                'vacunas' => 'Rabia, trivalente y leucemia',
                'informes_de_mascota' => json_encode(['informe1.doc', 'resultado.doc', 'informe2.doc']),
                'historial_clinico' => 'castrado',
                'dni' => '01189877H',
            ]
        ]);

        DB::table('mascotas')->insert([
            [
                'num_chip' => 7896541,
                'nombre_mascota' => 'Coco',
                'edad' => 2,
                'sexo' => 'M',
                'especie' => 'gato',
                'vacunas' => 'Rabia, trivalente y leucemia',
                'informes_de_mascota' => json_encode(['informe1.doc', 'resultado.doc', 'informe2.doc']),
                'dni' => '01189877H',
            ]
        ]);

        DB::table('mascotas')->insert([
            [
                'num_chip' => 6542893,
                'nombre_mascota' => 'Mau',
                'edad' => 4,
                'sexo' => 'M',
                'especie' => 'gato',
                'vacunas' => 'Rabia, trivalente y leucemia',
                'informes_de_mascota' => json_encode(['informe1.doc', 'resultado.doc', 'informe2.doc']),
                'dni' => '12345678Z',
            ]
        ]);

        DB::table('mascotas')->insert([
            [
                'num_chip' => 4566981,
                'nombre_mascota' => 'Leo',
                'edad' => 12,
                'sexo' => 'M',
                'especie' => 'gato',
                'vacunas' => 'Rabia, trivalente y leucemia',
                'informes_de_mascota' => json_encode(['informe1.doc', 'resultado.doc', 'informe2.doc']),
                'dni' => '98745632C',
            ]
        ]);

        DB::table('mascotas')->insert([
            [
                'num_chip' => 7755689,
                'nombre_mascota' => 'Aru',
                'edad' => 3,
                'sexo' => 'H',
                'especie' => 'gato',
                'vacunas' => 'Rabia, trivalente y leucemia',
                'informes_de_mascota' => json_encode(['resultado.doc', 'resultado2.doc']),
                'historial_clinico' => 'madre',
                'dni' => '98745632C',
            ]
        ]);

        DB::table('mascotas')->insert([
            [
                'num_chip' => 1122334,
                'nombre_mascota' => 'Django',
                'edad' => 8,
                'sexo' => 'M',
                'especie' => 'perro',
                'vacunas' => 'Rabia y polivalente',
                'informes_de_mascota' => json_encode(['analitica.doc']),
                'historial_clinico' => 'viejito',
                'dni' => '58236478A',
            ]
        ]);

        DB::table('mascotas')->insert([
            [
                'num_chip' => 6987354,
                'nombre_mascota' => 'Mango',
                'edad' => 6,
                'sexo' => 'H',
                'especie' => 'perro',
                'vacunas' => 'Rabia y polivalente',
                'informes_de_mascota' => json_encode(['informe.doc']),
                'historial_clinico' => 'castrado',
                'dni' => '44556677G',
            ]
        ]);
    }
}
