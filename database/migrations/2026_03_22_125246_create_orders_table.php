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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');           // foreign key 
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');    // pending, processing, shipped, delivered, cancelled
            $table->string('payment_method')->nullable();
            $table->text('shipping_address')->nullable();

            $table->timestamps();

            // Foreign key للمستخدم (من جدول users اللي موجود من Breeze)
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
