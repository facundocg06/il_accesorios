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
        Schema::create('details_adjustments', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->foreignId('inventory_adjustment_id')->constrained()->onDelete('cascade');
            $table->foreignId('stock_sale_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_adjustments');
    }
};
