<?php


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    use HasFactory;

    // Establecer los campos que pueden ser llenados de forma masiva
    protected $fillable = [
        'nombre',      // Nombre completo del usuario
        'email',       // Correo electrónico único
        'password',    // Contraseña (encriptada)
        'role',        // Rol de usuario: admin, vendedor, etc.
    ];

    // Para evitar que la contraseña sea incluida en los resultados de las consultas
    protected $hidden = [
        'password',
    ];

    // Para poder realizar la validación de la contraseña usando el sistema de autenticación
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Puedes agregar un método para verificar si el usuario es un administrador
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Método para verificar si el usuario es un vendedor
    public function isVendedor()
    {
        return $this->role === 'vendedor';
    }
}
