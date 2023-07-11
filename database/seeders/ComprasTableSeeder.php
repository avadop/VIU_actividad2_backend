<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComprasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('compras')->insert([
            ['fecha_compra' => '2023/07/03',
             'id_producto'=>'13',
             'dni'=>'01189877H',
            ],
            ['fecha_compra' => '2023/03/07',
            'id_producto'=>'1',
            'dni'=>'01189877H',
            ],
            ['fecha_compra' => '2023/05/12',
            'id_producto'=>'6',
            'dni'=>'01189877H',
            ],
            ['fecha_compra' => '2023/05/11',
            'id_producto'=>'5',
            'dni'=>'58236478A',
            ],
            ['fecha_compra' => '2023/05/11',
            'id_producto'=>'2',
            'dni'=>'58236478A',
            ],
            ['fecha_compra' => '2023/04/22',
            'id_producto'=>'7',
            'dni'=>'44556677G',
            ],
         

        ]);
    }
}
