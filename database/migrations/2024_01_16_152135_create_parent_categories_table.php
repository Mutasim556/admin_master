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
        Schema::create('parent_categories', function (Blueprint $table) {
            $table->id();
            $table->string('parent_category_name');
            $table->string('parent_category_image')->nullable();
            $table->boolean('parent_category_status')->default(1);
            $table->boolean('parent_category_delete')->default(0)->comment('0=Not Deleted 1=Deleted');
            $table->foreignId('parent_category_added_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_categories');
    }
};
