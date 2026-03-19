<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalTable extends Migration
    {
        public function up()
        {
            Schema::create('sucursal', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('direccion');
                $table->string('telefono');
                $table->timestamps();
            });
        }
    
        public function down()
        {
            Schema::dropIfExists('sucursal');
        }
    }
    
