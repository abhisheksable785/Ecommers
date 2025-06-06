<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('price');
            $table->enum('gender', ['Men', 'Women', 'Unisex'])->default('Unisex');
            $table->string('description');
            $table->string('category');
            $table->integer('stock_quantity')->default(0);
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_product');
    }
};
