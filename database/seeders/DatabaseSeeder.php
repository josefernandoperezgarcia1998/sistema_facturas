<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'José Fernando Pérez García',
            'email' => 'jfpg@gmail.com',
            'password' => bcrypt('123'),
            'rol' => 'Administrador',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Juan Pablo Prats Ovilla',
            'email' => 'jpratso@gmail.com',
            'password' => bcrypt('123'),
            'rol' => 'Proveedor',
        ]);
    }
}
