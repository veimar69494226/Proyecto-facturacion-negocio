<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Especificamos el nombre de la tabla
    protected $table = 'producto';

    // Campos que se pueden llenar de forma masiva
    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'cantidad',
        'imagen',
        'categoria',
    ];

    // Si tu tabla no tiene los timestamps, puedes deshabilitarlos
    // public $timestamps = false;
}
