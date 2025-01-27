<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => 'Rojo', 'hex' => '#FF0000'],
            ['name' => 'Verde', 'hex' => '#00FF00'],
            ['name' => 'Azul', 'hex' => '#0000FF'],
            ['name' => 'Amarillo', 'hex' => '#FFFF00'],
            ['name' => 'Negro', 'hex' => '#000000'],
            ['name' => 'Blanco', 'hex' => '#FFFFFF'],
            ['name' => 'Cian', 'hex' => '#00FFFF'],
            ['name' => 'Magenta', 'hex' => '#FF00FF'],
            ['name' => 'Naranja', 'hex' => '#FFA500'],
            ['name' => 'Marrón', 'hex' => '#A52A2A'],
            ['name' => 'Rosa', 'hex' => '#FFC0CB'],
            ['name' => 'Gris', 'hex' => '#808080'],
        ]);
    }
}
