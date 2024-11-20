<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RolPermissionSeeder::class]);
        $this->call([SupplierSeeder::class]);
        $this->call([ColorSeeder::class]);
        $this->call([BrandSeeder::class]);
        $this->call([SizeSeeder::class]);
        $this->call([StoreSeeder::class]);
        $this->call([StockProductionSeeder::class]);
        $this->call([UserSeeder::class]);
    }
}
