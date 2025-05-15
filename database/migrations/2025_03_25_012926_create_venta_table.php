<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaTable extends Migration
{
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPedido')->constrained('pedido');
            $table->foreignId('idVendedor')->constrained('vendedor');
            $table->decimal('total', 10, 2);
            $table->dateTime('fecha_venta');
            $table->foreignId('idSucursal')->constrained('sucursal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('venta');
    }
}
