<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GruposTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            ['name' => 'ADMINISTRADOR'],
            ['name' => 'COORDENADOR'],
            ['name' => 'PERFIL DE QUALIDADE'],
            ['name' => 'ATENDENTE'],
        ]);
    }
}
