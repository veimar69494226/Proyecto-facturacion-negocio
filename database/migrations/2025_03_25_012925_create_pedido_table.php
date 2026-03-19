<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoTable extends Migration
{
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idCliente')->constrained('cliente');
            $table->foreignId('idVendedor')->constrained('vendedor'); // El vendedor es un usuario
            $table->foreignId('idSucursal')->constrained('sucursal');
            $table->dateTime('fecha');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido');
    }
}
