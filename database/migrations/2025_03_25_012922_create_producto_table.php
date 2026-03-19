<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 8, 2);
            $table->text('descripcion')->nullable();
            $table->integer('cantidad');
            $table->string('imagen',500);
            $table->string('categoria');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
