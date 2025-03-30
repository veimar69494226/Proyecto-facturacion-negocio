<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido'; // Nombre singular de la tabla

    protected $fillable = [
        'idCliente', // Referencia al cliente
        'fecha',     // Fecha y hora del pedido
    ];

    // Relación con la tabla cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }

    // Relación con la tabla detalle_pedidos
    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class, 'idPedido');
    }
}
