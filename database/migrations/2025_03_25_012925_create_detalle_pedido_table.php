<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPedido')->constrained('pedido')->onDelete('cascade');
            $table->foreignId('idProducto')->constrained('producto')->onDelete('cascade');
            $table->integer('cantidad');
            $table->string('estado_pedido');
            $table->decimal('subtotal', 10, 2);
            $table->integer('total');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
    }
};
