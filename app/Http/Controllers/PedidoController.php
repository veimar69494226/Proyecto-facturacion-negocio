<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    // Mostrar todos los pedidos
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'vendedor', 'sucursal', 'detalles'])->get();

        return response()->json($pedidos, 200);
    }

    // Crear un nuevo pedido
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'idCliente' => 'required|exists:cliente,id',
            'idVendedor' => 'required|exists:vendedor,id',
            'idSucursal' => 'required|exists:sucursal,id',
            'fecha' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear el pedido
        $pedido = Pedido::create([
            'idCliente' => $request->idCliente,
            'idVendedor' => $request->idVendedor,
            'idSucursal' => $request->idSucursal,
            'fecha' => $request->fecha,
        ]);

        return response()->json([
            'message' => 'Pedido creado exitosamente',
            'pedido' => $pedido,
        ], 201);
    }

    // Mostrar un solo pedido por ID
    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'vendedor', 'sucursal', 'detalles'])->find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json($pedido, 200);
    }

    // Actualizar un pedido
    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'idCliente' => 'sometimes|required|exists:cliente,id',
            'idVendedor' => 'sometimes|required|exists:vendedor,id',
            'idSucursal' => 'sometimes|required|exists:sucursal,id',
            'fecha' => 'sometimes|required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar el pedido
        $pedido->update($request->only([
            'idCliente',
            'idVendedor',
            'idSucursal',
            'fecha'
        ]));

        return response()->json([
            'message' => 'Pedido actualizado exitosamente',
            'pedido' => $pedido,
        ], 200);
    }

    // Eliminar un pedido
    public function destroy($id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        // Eliminar el pedido
        $pedido->delete();

        return response()->json(['message' => 'Pedido eliminado exitosamente'], 200);
    }
}