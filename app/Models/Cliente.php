<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    // Definir los campos que son asignables masivamente
    protected $fillable = ['nombre', 'telefono'];

    // Definir las relaciones con otros modelos si es necesario
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
