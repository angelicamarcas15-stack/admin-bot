<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbigeoDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ubigeo_department')->insert([
            ['id_depa' => 1, 'department' => 'AMAZONAS'],
            ['id_depa' => 2, 'department' => 'ANCASH'],
            ['id_depa' => 3, 'department' => 'APURIMAC'],
            ['id_depa' => 4, 'department' => 'AREQUIPA'],
            ['id_depa' => 5, 'department' => 'AYACUCHO'],
            ['id_depa' => 6, 'department' => 'CAJAMARCA'],
            ['id_depa' => 7, 'department' => 'CALLAO'],
            ['id_depa' => 8, 'department' => 'CUSCO'],
            ['id_depa' => 9, 'department' => 'HUANCAVELICA'],
            ['id_depa' => 10, 'department' => 'HUANUCO'],
            ['id_depa' => 11, 'department' => 'ICA'],
            ['id_depa' => 12, 'department' => 'JUNIN'],
            ['id_depa' => 13, 'department' => 'LA LIBERTAD'],
            ['id_depa' => 14, 'department' => 'LAMBAYEQUE'],
            ['id_depa' => 15, 'department' => 'LIMA'],
            ['id_depa' => 16, 'department' => 'LORETO'],
            ['id_depa' => 17, 'department' => 'MADRE DE DIOS'],
            ['id_depa' => 18, 'department' => 'MOQUEGUA'],
            ['id_depa' => 19, 'department' => 'PASCO'],
            ['id_depa' => 20, 'department' => 'PIURA'],
            ['id_depa' => 21, 'department' => 'PUNO'],
            ['id_depa' => 22, 'department' => 'SAN MARTIN'],
            ['id_depa' => 23, 'department' => 'TACNA'],
            ['id_depa' => 24, 'department' => 'TUMBES'],
            ['id_depa' => 25, 'department' => 'UCAYALI'],
        ]);
    }
}
