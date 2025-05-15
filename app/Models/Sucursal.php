<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'sucursal';

    // Campos que se pueden llenar de forma masiva
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
    ];
}
