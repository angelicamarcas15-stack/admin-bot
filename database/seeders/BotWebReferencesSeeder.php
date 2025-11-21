<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BotWebReferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bot_web_references')->insert([
            [
                'title' => 'SUNAT - Superintendencia Nacional de Aduanas y de Administración Tributaria',
                'url' => 'https://www.sunat.gob.pe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'SUNARP - Superintendencia Nacional de los Registros Públicos',
                'url' => 'https://www.sunarp.gob.pe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'GOB.PE - Portal del Estado Peruano',
                'url' => 'https://www.gob.pe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
