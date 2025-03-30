<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\VentaController;
// Definir ruta API de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando correctamente']);
});

// Definir rutas API de clientes
Route::apiResource('clientes', ClienteController::class);

//rutas para productos
Route::apiResource('productos', ProductoController::class);
//rutas para pedido 
Route::apiResource('pedidos', PedidoController::class);
//rutas para el detalle de factura de un pedido 
Route::apiResource('detalle_pedidos', DetallePedidoController::class);
//ruta para vendedor 
Route::apiResource('vendedores', VendedorController::class);
//ruta para ventas realizadas 
Route::apiResource('ventas', VentaController::class);
// Ruta que acepta un parámetro de fecha
Route::get('/ventas/total-del-dia/{fecha}', [VentaController::class, 'getTotalVentasDelDia']);





