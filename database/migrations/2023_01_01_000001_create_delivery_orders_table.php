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
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Links to Sales Order
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('delivery_number')->unique();
            $table->date('delivery_date');
            $table->string('status')->default('pending'); // e.g., pending, in_transit, delivered, cancelled
            $table->text('shipping_address');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};
