<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->id();
            
            // Basic Product Information
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->nullable();
            $table->text('description');
            
            // Images
            $table->string('image'); // Main product image
            $table->json('gallery_images')->nullable(); // Multiple gallery images
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->boolean('charge_tax')->default(true);
            
            // Classification
            $table->enum('gender', ['Men', 'Women', 'Unisex', 'Kids'])->default('Unisex');
            $table->string('category');
            $table->string('brand')->nullable();
            
            // Inventory Management
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(10);
            $table->boolean('in_stock')->default(true);
            
            // Variants (stored as JSON)
            $table->json('variants')->nullable(); // [{type: 'size', value: 'M'}, {type: 'color', value: 'Red'}]
            
            // Shipping Information
            $table->decimal('weight', 8, 2)->nullable(); // in kg
            $table->string('dimensions')->nullable(); // e.g., "10x10x5"
            $table->boolean('free_shipping')->default(false);
            
            // Product Attributes
            $table->boolean('is_fragile')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            
            // Organization
            $table->enum('status', ['published', 'draft', 'inactive'])->default('published');
            $table->string('tags')->nullable(); // Comma-separated tags
            
            // SEO (Optional but useful)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Additional tracking
            $table->integer('views')->default(0);
            $table->integer('sales_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes(); // Soft delete support
            
            // Indexes for better performance
            $table->index('category');
            $table->index('gender');
            $table->index('status');
            $table->index('is_featured');
            $table->index('is_new');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tbl_product');
    }
};