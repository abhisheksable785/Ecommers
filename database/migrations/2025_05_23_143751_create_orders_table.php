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
            $table->unsignedBigInteger('user_id')->nullable(); // Make nullable if guest checkout is allowed
            // You might want a separate 'order_number' for display purposes, 
            // distinct from the auto-incrementing ID.
            $table->string('order_number')->unique(); 
            $table->string('full_name');
            $table->string('email'); // Removed unique constraint as a user can have multiple orders
            // Changed to string to accommodate various formats and leading zeros. 
            // Removed unique as a phone number can be associated with multiple orders.
            $table->string('mobile_number'); 
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending'); // Added payment status
            // Enum for status to ensure data consistency. You can add more statuses as needed.
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'refunded', 'failed'])->default('pending');
            $table->timestamp('order_date')->useCurrent(); // Explicit order date column
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Changed to set null so orders are kept even if user is deleted
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