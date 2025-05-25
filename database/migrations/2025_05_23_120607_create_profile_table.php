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
    Schema::create('profile', function (Blueprint $table) {

        $table->id();
         $table->unsignedBigInteger('user_id')->unique();
        $table->string('full_name');
        $table->string('mobile_number')->unique();
        $table->string('email')->unique();
        $table->date('birthday');
        $table->text('address');
        $table->string('city');
        $table->string('pincode');
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
        Schema::dropIfExists('profile');
    }
};
