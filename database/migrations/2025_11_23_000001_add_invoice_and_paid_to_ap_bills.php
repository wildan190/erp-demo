<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ap_bills', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->nullable()->after('supplier_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
            $table->timestamp('paid_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('ap_bills', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropColumn(['invoice_id','paid_at']);
        });
    }
};
