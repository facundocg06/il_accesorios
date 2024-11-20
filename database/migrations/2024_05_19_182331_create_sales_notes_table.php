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
        Schema::create('sales_notes', function (Blueprint $table) {
            $table->id();
            //Relacion con el Cliente
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->dateTime('sale_date');
            $table->float('total_quantity');
            $table->enum('sale_state',['RESERVADA','PAGADO','CANCELADA']);
            $table->enum('payment_method',['EFECTIVO','QR','TARJETA']);

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
        Schema::dropIfExists('sales_notes');
    }
};
