<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stock_productions')->insert([
            [
                'name' => 'Tela de Algodón',
                'price' => 50.0,
                'description' => 'Tela de algodón de alta calidad',
                'suppliers_id' => 1,
            ],
            [
                'name' => 'Hilo de Poliéster',
                'price' => 25.0,
                'description' => 'Hilo de poliéster resistente',
                'suppliers_id' => 1,
            ],
            [
                'name' => 'Botones de Metal',
                'price' => 30.0,
                'description' => 'Botones de metal para chaquetas',
                'suppliers_id' => 2,
            ],
            [
                'name' => 'Cremalleras de Plástico',
                'price' => 15.0,
                'description' => 'Cremalleras de plástico de alta durabilidad',
                'suppliers_id' => 2,
            ],
            [
                'name' => 'Encaje de Algodón',
                'price' => 40.0,
                'description' => 'Encaje de algodón para vestidos',
                'suppliers_id' => 3,
            ],
            [
                'name' => 'Tela de Lino',
                'price' => 60.0,
                'description' => 'Tela de lino de alta calidad',
                'suppliers_id' => 3,
            ],
            [
                'name' => 'Elástico de Tela',
                'price' => 10.0,
                'description' => 'Elástico de tela para ropa interior',
                'suppliers_id' => 1,
            ],
            [
                'name' => 'Cinta de Raso',
                'price' => 20.0,
                'description' => 'Cinta de raso para adornos',
                'suppliers_id' => 2,
            ],
            [
                'name' => 'Lana Merino',
                'price' => 75.0,
                'description' => 'Lana merino para suéteres',
                'suppliers_id' => 3,
            ],
        ]);
    }
}
