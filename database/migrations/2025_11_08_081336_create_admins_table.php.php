<?php

use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
             $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
           

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });


        FacadesDB::table('admins')->insert([
        'name'       => 'Super Admin',
        'phone'      => '9876543210',
        'email'      => 'super@ajspire.com',
        'password'   => Hash::make('super@ajspire.com'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
