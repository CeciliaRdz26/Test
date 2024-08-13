<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clientes')->insert([
            [
                'nombre' => 'Juan Pérez',
                'correo' => 'juan@gmail.com',
                'telefono' => '5554551234',
                'direccion' => 'Calle Falsa 123',
                'razon_social' => 'Juan Pérez S.A. de C.V.',
                'codigo_postal' => '12345',
                'regimen_fiscal' => 'Persona Moral',
                'rfc' => 'JUAP880101HDFRNS09',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María López',
                'correo' => 'maria.lopez@gmail.com',
                'telefono' => '5554555678',
                'direccion' => 'Avenida Siempre Viva 742',
                'razon_social' => 'María López S.A. de C.V.',
                'codigo_postal' => '12345',
                'regimen_fiscal' => 'Persona Moral',
                'rfc' => 'MALO750302HDFXNR09',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
