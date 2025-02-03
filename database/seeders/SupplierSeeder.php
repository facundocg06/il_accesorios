<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            ['nit_supplier' => 111,
            'reason_social' => 'Proveedor 1',
            'phone_supplier' => 111
            ],

            ['nit_supplier' => 222,
            'reason_social' => 'Proveedor 2',
            'phone_supplier' => 222
            ],

            ['nit_supplier' => 333,
            'reason_social' => 'Proveedor 3',
            'phone_supplier' => 333
            ],


        ]);
    }
}
