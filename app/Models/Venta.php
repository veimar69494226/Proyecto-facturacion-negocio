<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';  // Nombre de la tabla

    protected $fillable = [
        'idPedido',
        'idVendedor',
        'total',
        'fecha_venta',
    ];

    // Relación con la tabla Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'idPedido');
    }

    // Relación con la tabla Vendedor
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'idVendedor');
    }
}

