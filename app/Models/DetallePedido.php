<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'detalle_pedido'; // Tabla singular

    protected $fillable = [
        'idPedido',
        'idProducto',
        'cantidad',
        'estado_pedido',
        'subtotal',
        'total',
    ];

    // Relación con Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'idPedido');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto');
    }
}
