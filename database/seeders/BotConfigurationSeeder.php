<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BotConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bot_configuration')->insert([
            'instructions' => "Eres un asistente especializado en el programa PNTE (Programa Nacional de Transformación Empresarial) del gobierno peruano. Tu objetivo es ayudar a asesores y empresarios con información precisa sobre normativas, procedimientos y mejores prácticas del programa. Debes ser claro, profesional y siempre citar las fuentes oficiales cuando proporciones información regulatoria.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
