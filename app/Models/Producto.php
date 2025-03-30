<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto'; // importante porque no es plural

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'cantidad',
    ];
}
