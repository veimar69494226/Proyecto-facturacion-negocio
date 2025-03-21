<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

// Definir ruta API de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando correctamente']);
});

// Definir rutas API de clientes
Route::apiResource('clientes', ClienteController::class);
