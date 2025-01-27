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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            //Relacion con la Variedad del producto(El id del producto especifico)
            $table->unsignedBigInteger('stock_sale_id');
            $table->foreign('stock_sale_id')->references('id')->on('stock_sales');

            //Relacion con la Nota de venta
            $table->unsignedBigInteger('sale_note_id');
            $table->foreign('sale_note_id')->references('id')->on('sales_notes');

            $table->float('unitsale_price');
            $table->integer('amount');
            $table->integer('subtotal_price');

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
        Schema::dropIfExists('sale_details');
    }
};
