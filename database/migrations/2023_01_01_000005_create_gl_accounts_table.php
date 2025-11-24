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
        Schema::create('gl_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->string('account_name');
            $table->string('account_type'); // e.g., Asset, Liability, Equity, Revenue, Expense
            $table->foreignId('parent_account_id')->nullable()->constrained('gl_accounts')->nullOnDelete();
            $table->boolean('is_contra')->default(false); // e.g., Accumulated Depreciation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gl_accounts');
    }
};
