<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            [
                'nombre_categoria' => 'Comida',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_categoria' => 'Computo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Añade más categorías si lo deseas
        ]);
    }
}
