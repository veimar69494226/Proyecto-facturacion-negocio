<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedor';

    protected $fillable = [
        'idUsuarios',
        'telefono',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idUsuarios');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'idVendedor');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idVendedor');
    }
}