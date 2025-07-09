<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendedorTable extends Migration
{
    public function up()
    {
        Schema::create('vendedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsuarios')->constrained('usuarios'); // Asegúrate que la relación sea correcta
            $table->string('telefono')->nullable(); // Si quieres un teléfono, lo puedes hacer opcional
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendedor');
    }
}
