<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ap_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ap_bill_id');
            $table->string('payment_number')->unique();
            $table->decimal('amount', 15, 2);
            $table->date('payment_date')->nullable();
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('ap_bill_id')->references('id')->on('ap_bills')->onDelete('cascade');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ap_payments');
    }
};
