<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UsuariosController;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\Vendedor;
use App\Models\Venta;

// Definir ruta API de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando correctamente']);
});
///////////////////////


// Ruta para registrar un nuevo usuario
Route::post('usuario/register', [UsuariosController::class, 'register']);

// Ruta para iniciar sesión
Route::post('usuario/login', [UsuariosController::class, 'login']);

// Rutas para obtener todos los usuarios y por ID (sin autenticación)
Route::get('usuarios', [UsuariosController::class, 'getAllUsers']); // Obtener todos los usuarios
Route::get('usuario/{id}', [UsuariosController::class, 'getUserById']); // Obtener un usuario por ID

//ruta para clientes
Route::apiResource('cliente', ClienteController::class);
//ruta para pedido
Route::apiResource('pedido', PedidoController::class);
//ruta para vendedor
Route::apiResource('vendedor', VendedorController::class);
//ruta para sucursal
Route::apiResource('sucursal', SucursalController::class);
//ruta para producto 
Route::apiResource('producto', ProductoController::class);
//ruta para detalle pedido
Route::apiResource('detalle-pedido',DetallePedidoController::class);
//actualizar
Route::put('/detalle-pedido/{idPedido}', [DetallePedidoController::class, 'update']);

// Obtener el total de ventas del día (opcionalmente con fecha)
  Route::get('/ventas/total-dia/{fecha?}', [VentaController::class, 'getTotalVentasDelDia']);

// ruta venta
Route::apiResource('venta',VentaController::class);