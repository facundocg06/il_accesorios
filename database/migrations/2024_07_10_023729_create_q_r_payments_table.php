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
        Schema::create('qr_payments', function (Blueprint $table) {
            $table->id();
            $table->string('cod_transaction');
            $table->string('cod_qr');
            $table->text('qr_code');
            $table->unsignedBigInteger('sale_note_id');
            $table->foreign('sale_note_id')->references('id')->on('sales_notes');
            $table->enum('payment_status',['PAGADED','PENDING'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_payments');
    }
};
