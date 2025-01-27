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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            //Relacion con la Nota de compra
            $table->unsignedBigInteger('purchase_note_id');
            $table->foreign('purchase_note_id')->references('id')->on('purchase_notes')->onDelete('cascade');

            //Relacion con item de produccion
            $table->unsignedBigInteger('stock_production_id');
            $table->foreign('stock_production_id')->references('id')->on('stock_productions');

            $table->integer('amount');
            $table->float('price_purchase_detail');

            $table->enum('deleted',['ACTIVO','INACTIVO'])->default('ACTIVO');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
