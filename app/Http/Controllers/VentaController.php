<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        return response()->json(Venta::with('pedido', 'vendedor')->get(), 200);
    }
//ventas por dia
// En tu controlador
public function getTotalVentasDelDia($fecha = null)
{
    $fecha = $fecha ? $fecha : today(); // Si no pasa una fecha en la ruta, usa la fecha de hoy.
    $ventasDelDia = Venta::whereDate('fecha_venta', $fecha)->sum('total');

    return response()->json([
        'message' => 'Total de ventas del día',
        'total_ventas' => $ventasDelDia,
    ], 200);
}


    public function store(Request $request)
    {
        $request->validate([
            'idPedido' => 'required|exists:pedido,id',
            'idVendedor' => 'required|exists:vendedor,id',
            'total' => 'required|numeric',
            'fecha_venta' => 'required|date',
        ]);

        $venta = Venta::create($request->all());

        return response()->json([
            'message' => 'ventas del dia creadas exitosamente',
            'data' => $venta
        ], 201);
    }

    public function show($id)
    {
        $venta = Venta::with('pedido', 'vendedor')->find($id);

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        return response()->json($venta, 200);
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        $venta->update($request->all());

        return response()->json($venta, 200);
    }

    public function destroy($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        $venta->delete();

        return response()->json(['message' => 'Venta eliminada correctamente'], 200);
    }
}
