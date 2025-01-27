<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 DB::table('sizes')->insert([
            // Tallas de ropa
            ['name' => 'Talla XXS'],
            ['name' => 'Talla XS'],
            ['name' => 'Talla S'],
            ['name' => 'Talla M'],
            ['name' => 'Talla L'],
            ['name' => 'Talla XL'],
            ['name' => 'Talla XXL'],
            ['name' => 'Talla XXXL'],

            // Tallas de zapatos (US)
            ['name' => 'Talla 5 (Zapatos)'],
            ['name' => 'Talla 6 (Zapatos)'],
            ['name' => 'Talla 7 (Zapatos)'],
            ['name' => 'Talla 8 (Zapatos)'],
            ['name' => 'Talla 9 (Zapatos)'],
            ['name' => 'Talla 10 (Zapatos)'],
            ['name' => 'Talla 11 (Zapatos)'],
            ['name' => 'Talla 12 (Zapatos)'],
            ['name' => 'Talla 13 (Zapatos)'],
        ]);
    }
}
