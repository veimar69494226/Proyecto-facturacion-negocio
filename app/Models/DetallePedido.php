<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    // Especificamos el nombre de la tabla
    protected $table = 'detalle_pedido';

    // Campos que se pueden llenar de forma masiva
    protected $fillable = [
        'idPedido',
        'idProducto',
        'cantidad',
        'estado_pedido',
        'subtotal',
        'total',
    ];

    // Relación con el modelo Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'idPedido');
    }

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto');
    }
}
