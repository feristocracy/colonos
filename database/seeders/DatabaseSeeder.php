<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Fernando Maldonado',
            'email' => 'fermaldonadosolis@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('Ragnarok.7'),
            'email_verified_at' => now()
        ]);
        User::factory()->create([
            'name' => 'Karen Melissa Pastrana',
            'email' => 'karen@gmail.com',
            'role' => 'tesorero',
            'password' => Hash::make('Ragnarok.7'),
            'email_verified_at' => now()
        ]);
    }
}
