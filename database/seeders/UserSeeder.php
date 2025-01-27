<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'Luis Torres',
            'email' => 'luis@gmail.com',
            'password' => Hash::make('123456789'),
            'first_name' => 'Tuis',
            'last_name' => 'Torres',
            'phone' => '77807205',
        ]);
        $user->assignRole('Administrador');

        $user = User::create([
            'username' => 'melissa fisher',
            'email' => 'melissa@gmail.com',
            'password' => Hash::make('123456789'),
            'first_name' => 'melissa',
            'last_name' => 'fisher',
            'phone' => '78198215',
        ]);
        $user->assignRole('Administrador');

        $user = User::create([
            'username' => 'ivana',
            'email' => 'ivana@gmail.com',
            'password' => Hash::make('123456789'),
            'first_name' => 'ivana',
            'last_name' => 'ivana',
            'phone' => '73666238',
        ]);
        $user->assignRole('Administrador');
    }
}
