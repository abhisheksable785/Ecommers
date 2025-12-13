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

        // User null allowed (Guest Checkout possible)
        $table->unsignedBigInteger('user_id')->nullable();

        // Professional order number format: ORD-20250101-XYZ
        $table->string('order_number')->unique();

        // Billing Details
        $table->string('full_name');
        $table->string('email');  // No unique (multiple orders possible)
        $table->string('mobile_number'); // No unique, string for leading 0

        // Shipping
        $table->text('address');
        $table->string('city');
        $table->string('state');
        $table->string('country')->default('India');
        $table->string('pincode');

        // Payment
        $table->decimal('total_amount', 10, 2);
        $table->enum('payment_method', ['cod', 'razorpay', 'stripe', 'wallet'])
              ->nullable();

        $table->enum('payment_status', ['pending', 'success', 'failed', 'refunded']);

        // Order status (seller side)
        $table->enum('status', [
            'pending',
            'processing',
            'packed',
            'shipped',
            'delivered',
            'cancelled',
            'refunded',
            'failed'
        ])->default('pending');

        // Timestamps
        $table->timestamp('order_date')->useCurrent();
        $table->timestamps();

        // Foreign Key
        $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
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