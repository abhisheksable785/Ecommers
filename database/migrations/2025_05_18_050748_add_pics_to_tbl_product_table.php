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
    Schema::table('tbl_product', function (Blueprint $table) {
        $table->json('pics')->nullable()->after('image');
    });
}

public function down()
{
    Schema::table('tbl_product', function (Blueprint $table) {
        $table->dropColumn('pics');
    });
}


    /**
     * Reverse the migrations.
     *
     * 
     */
   
};
