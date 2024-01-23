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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('type');
            $table->string('barcode_symbology');
            $table->foreignId('brand_id')->nullable()->references('id')->on('brands');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('unit_id')->nullable()->references('id')->on('units');
            $table->integer('unit_size');
            $table->integer('cartoon_size');
            $table->integer('purchase_unit_id')->nullable();
            $table->integer('sale_unit_id')->nullable();
            $table->double('cost');
            $table->double('price');
            $table->double('qty')->nullable();
            $table->double('alert_quantity')->nullable();
            $table->double('daily_sale_objective')->nullable();
            $table->tinyInteger('promotion')->nullable();
            $table->string('promotion_price')->nullable();
            $table->date('starting_date')->nullable();
            $table->date('last_date')->nullable();
            $table->integer('tax_id')->nullable();
            $table->integer('tax_method')->nullable();
            $table->longText('image')->nullable();
            $table->string('file')->nullable();
            $table->tinyInteger('is_embeded')->nullable();
            $table->tinyInteger('is_variant')->nullable();
            $table->tinyInteger('is_batch')->nullable();
            $table->tinyInteger('is_diffPrice')->nullable();
            $table->tinyInteger('is_imei')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->string('product_list')->nullable();
            $table->string('variant_list')->nullable();
            $table->string('qty_list')->nullable();
            $table->string('price_list')->nullable();
            $table->text('product_details')->nullable();
            $table->string('variant_option')->nullable();
            $table->string('variant_value')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('delete')->default(0)->comment('0= Not Deleted & 1=Deleted');
            $table->foreignId('created_by')->references('id')->on('admins');
            $table->foreignId('updated_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
