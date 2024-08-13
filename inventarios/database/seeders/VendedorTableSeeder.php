<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendedor')->insert([
            [
                'nombre' => 'Pedro',
                'correo' => 'pedro@gmail.com',
                'telefono' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Juan',
                'correo' => 'juan@gmail.com',
                'telefono' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Añade más categorías si lo deseas
        ]);
    }
}
