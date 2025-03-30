<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        return response()->json(Pedido::with('cliente')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idCliente' => 'required|exists:cliente,id',
            'fecha' => 'required|date',
        ]);

        $pedido = Pedido::create($request->all());

        return response()->json([
            'message' => 'pedido registrado exitosamente',
            'data' => $pedido
        ], 201);
    }

    public function show($id)
    {
        $pedido = Pedido::with('cliente', 'detallePedidos')->find($id);

        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        return response()->json($pedido, 200);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        $pedido->update($request->all());

        return response()->json($pedido, 200);
    }

    public function destroy($id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        $pedido->delete();

        return response()->json(['message' => 'Pedido eliminado correctamente'], 200);
    }
}
