<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedor';  // Nombre de la tabla (singular)

    protected $fillable = [
        'nombre',  // Define los campos que pueden ser asignados masivamente
    ];

    // Relación con las ventas (un vendedor puede hacer múltiples ventas)
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idVendedor');
    }
}

