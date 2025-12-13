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
 // database/migrations/xxxx_create_notifications_table.php
public function up()
{
  
Schema::create('notifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    $table->string('title');
    $table->text('message');
    $table->string('image')->nullable();
    $table->string('player_id')->nullable();
    $table->string('priority')->default('normal');
    $table->string('action_url')->nullable();
    $table->timestamp('scheduled_at')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
