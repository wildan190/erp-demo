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
        Schema::create('gl_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gl_transaction_id')->constrained('gl_transactions')->cascadeOnDelete();
            $table->foreignId('gl_account_id')->constrained('gl_accounts')->cascadeOnDelete();
            $table->decimal('debit', 12, 2)->default(0);
            $table->decimal('credit', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gl_transaction_items');
    }
};
