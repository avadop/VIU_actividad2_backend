<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlertasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alertas')->insert([
            ['mensaje' => 'Bajo Stock',
             'stock_restante'=>'10',
             'fecha_alerta'=>'2023/01/25',
             'id_producto'=>'1',
            ],
            ['mensaje' => 'Bajo Stock',
             'stock_restante'=>'10',
             'fecha_alerta'=>'2022/08/06',
             'id_producto'=>'4',
            ],
            ['mensaje' => 'Bajo Stock',
             'stock_restante'=>'10',
             'fecha_alerta'=>'2023/02/22',
             'id_producto'=>'11',
            ],
            ['mensaje' => 'Bajo Stock',
             'stock_restante'=>'10',
             'fecha_alerta'=>'2023/05/13',
             'id_producto'=>'10',
            ],

        ]);

    }
}
