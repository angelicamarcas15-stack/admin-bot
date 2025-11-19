<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ubigeo_district', function (Blueprint $table) {
            $table->unsignedInteger('id_dist')->primary();
            $table->string('district', 50)->nullable();
            $table->unsignedInteger('id_prov');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubigeo_district');
    }
};
