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
        Schema::create('units', function (Blueprint $table) {
            $table->id('id');
            $table->string('unit_code');
            $table->string('unit_name');
            $table->string('base_unit')->nullable();
            $table->string('operator')->nullable();
            $table->double('operation_value')->nullable();
            $table->boolean('unit_status')->default(0);
            $table->string('unit_created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
