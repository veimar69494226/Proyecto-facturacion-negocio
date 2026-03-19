<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Definimos la tabla en caso de que no siga la convención de Laravel
    protected $table = 'pedido'; 

    // Campos que se pueden llenar de forma masiva
    protected $fillable = [
        'idCliente',
        'idVendedor',
        'idSucursal',
        'fecha',
    ];

    // Definimos las relaciones con otras tablas

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }

    // Relación con Vendedor
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'idVendedor');
    }

    // Relación con Sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idSucursal');
    }

    // Relación con DetallePedido
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'idPedido');
    }
}
