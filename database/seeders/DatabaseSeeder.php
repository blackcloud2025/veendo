<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // Roles disponibles desde la migración
         $roles = ['user', 'admin', 'publisher'];

         foreach ($roles as $role) {
             \App\Models\User::factory()->create([
                'role' => $role
             ]);
         }
    }
}
