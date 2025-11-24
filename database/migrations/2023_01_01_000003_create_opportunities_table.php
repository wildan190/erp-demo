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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null'); // Associated customer
            $table->foreignId('lead_id')->nullable()->constrained()->onDelete('set null'); // Associated lead
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Owner/Salesperson
            $table->decimal('expected_revenue', 12, 2)->nullable();
            $table->date('close_date')->nullable();
            $table->string('stage')->default('prospecting'); // e.g., prospecting, qualification, proposal, negotiation, won, lost
            $table->decimal('probability', 5, 2)->nullable(); // Probability of closing (0.00 to 1.00)
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
