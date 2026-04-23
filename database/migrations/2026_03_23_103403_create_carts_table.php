<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // User who owns this cart item
            $table->unsignedBigInteger('user_id');

            // The product in the cart
            $table->unsignedBigInteger('product_id');

            // How many pieces the user wants
            $table->integer('quantity')->default(1);

            // Timestamps
            $table->timestamps();

            // Foreign keys with cascade delete (clean data)
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            // Prevent duplicate items for same user + product
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
