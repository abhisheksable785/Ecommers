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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->text('comment')->nullable();
            $table->boolean('is_verified_purchase')->default(false); // set if user bought
            $table->boolean('is_approved')->default(true); // set false if admin approval needed
            $table->timestamps();

            $table->unique(['user_id', 'product_id']); // one review per user per product
            $table->index('product_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // product foreign key optional (if you have products table)
            $table->foreign('product_id')->references('id')->on('tbl_product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
