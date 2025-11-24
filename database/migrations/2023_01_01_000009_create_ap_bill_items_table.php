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
        Schema::create('ap_bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ap_bill_id')->constrained('ap_bills')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete(); // Link to existing products or generic description
            $table->string('description')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ap_bill_items');
    }
};
