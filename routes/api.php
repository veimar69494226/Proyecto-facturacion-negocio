<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UsuariosController;

// Definir ruta API de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando correctamente']);
});

// Ruta para registrar un nuevo usuario
Route::post('usuario/register', [UsuariosController::class, 'register']);

// Ruta para iniciar sesión
Route::post('usuario/login', [UsuariosController::class, 'login']);

// Rutas para obtener todos los usuarios y por ID
Route::get('usuarios', [UsuariosController::class, 'getAllUsers']);
Route::get('usuario/{id}', [UsuariosController::class, 'getUserById']);

// Rutas CRUD normales
Route::apiResource('cliente', ClienteController::class);
Route::apiResource('pedido', PedidoController::class);
Route::apiResource('vendedor', VendedorController::class);
Route::apiResource('sucursal', SucursalController::class);
Route::apiResource('producto', ProductoController::class);
Route::apiResource('venta', VentaController::class);

// Rutas personalizadas para detalle pedido
Route::get('detalle-pedido', [DetallePedidoController::class, 'index']);
Route::post('detalle-pedido', [DetallePedidoController::class, 'store']);
Route::get('detalle-pedido/{id}', [DetallePedidoController::class, 'show']);
Route::put('detalle-pedido/pedido/{idPedido}', [DetallePedidoController::class, 'update']);
Route::delete('detalle-pedido/{id}', [DetallePedidoController::class, 'destroy']);

// Obtener el total de ventas del día
Route::get('ventas/total-dia/{fecha?}', [VentaController::class, 'getTotalVentasDelDia']);