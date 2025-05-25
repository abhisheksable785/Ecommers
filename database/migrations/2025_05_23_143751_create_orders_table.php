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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->string('full_name');
    $table->string('email')->nullable();
    $table->string('mobile_number')->nullable();
    $table->text('address');
    $table->string('city');
    $table->string('state');
    $table->string('country');
    $table->string('pincode');
    $table->decimal('total_amount', 10, 2);
    $table->string('payment_method')->nullable();
    $table->string('status')->default('pending');
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
