<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'vendedor';

    // Campos que se pueden llenar de forma masiva
    protected $fillable = [
        'idUsuarios',
        'telefono',
    ];

    // Relación con Usuario (un vendedor es un usuario)
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class , 'idUsuarios');
    }
}
