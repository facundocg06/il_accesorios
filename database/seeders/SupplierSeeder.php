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
            [
                'nit_supplier' => 111,
                'reason_social' => 'Bazar Polpe',
                'phone_supplier' => 33465352
            ],

            [
                'nit_supplier' => 222,
                'reason_social' => 'Merceria El Detalle',
                'phone_supplier' => 33361313
            ],

            [
                'nit_supplier' => 333,
                'reason_social' => 'Bazar Kelly',
                'phone_supplier' => 33622945
            ],


        ]);
    }
}
