<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';

    protected $fillable = [
        'idPedido',
        'idVendedor',
        'total',
        'fecha_venta',
        'idSucursal',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'idPedido');
    }

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'idVendedor');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idSucursal');
    }
}