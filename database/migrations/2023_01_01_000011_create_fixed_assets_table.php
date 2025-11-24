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
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name');
            $table->text('description')->nullable();
            $table->string('asset_number')->unique()->nullable();
            $table->date('acquisition_date');
            $table->decimal('cost', 12, 2);
            $table->decimal('salvage_value', 12, 2)->default(0);
            $table->integer('useful_life_years');
            $table->string('depreciation_method'); // e.g., Straight-line, Declining Balance
            $table->decimal('current_value', 12, 2);
            $table->date('disposal_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_assets');
    }
};
