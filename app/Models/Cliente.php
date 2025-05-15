<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Si el nombre de la tabla no sigue la convención de Laravel, defínelo explícitamente
    protected $table = 'cliente'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos

    protected $fillable = [
        'nombre', 
    ];

    // Si tu tabla no tiene las columnas created_at y updated_at, puedes deshabilitarlas
    // public $timestamps = false;
}
