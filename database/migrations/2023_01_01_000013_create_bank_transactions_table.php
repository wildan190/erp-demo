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
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->constrained('bank_accounts')->cascadeOnDelete();
            $table->date('transaction_date');
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->string('type'); // e.g., debit, credit
            $table->boolean('is_reconciled')->default(false);
            $table->foreignId('gl_transaction_id')->nullable()->constrained('gl_transactions')->nullOnDelete(); // Link to a GL transaction if reconciled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
    }
};
