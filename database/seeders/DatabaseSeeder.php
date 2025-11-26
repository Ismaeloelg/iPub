<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Mesa;
use App\Models\Stock;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Mesa::factory(20)->create();
        $categorias = Categoria::factory(10)->create();

        foreach ($categorias as $categoria) {
            Stock::factory()
                ->count(10)
                ->create([
                    'categoria_id' => $categoria->id
                ]);
        }

        User::factory(3)->create();
        User::create([
            'name' => 'Noadmin',
            'password' => '1075',
            'avatar' => 'images/shinchan.png',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'admin',
            'password' => '1075',
            'avatar' => 'images/shinchan.png',
            'role' => 'admin',
        ]);

        Mesa::factory(10)->create();

    }

}
