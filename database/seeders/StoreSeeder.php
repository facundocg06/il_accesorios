<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->insert([
            [
                'name' => 'Tienda Principal',
                'location' => 'Calle Principal #123, Ciudad Principal',

            ],
            [
                'name' => 'Tienda Secundaria',
                'location' => 'Avenida Secundaria #456, Ciudad Secundaria',
            ],
            [
                'name' => 'Tienda Tercera',
                'location' => 'Boulevard Tercera #789, Ciudad Tercera',
            ],
        ]);
    }
}
