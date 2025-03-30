<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Obtener todos los clientes
     */
    public function index()
    {
        return response()->json(Cliente::all(), 200);
    }

    /**
     * Crear un nuevo cliente
     */
    public function store(Request $request)
    {
        // Validar entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        // Crear cliente
        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono
        ]);

        return response()->json([
            'message' => 'Cliente creado exitosamente',
            'data' => $cliente
        ], 201);
    }

    /**
     * Obtener un cliente específico
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    /**
     * Actualizar un cliente
     */
    public function update(Request $request, $id)
    {
        // Validar entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $cliente->update($request->all());

        return response()->json([
            'message' => 'Cliente actualizado exitosamente',
            'data' => $cliente
        ], 200);
    }

    /**
     * Eliminar un cliente
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado'], 200);
    }
}
