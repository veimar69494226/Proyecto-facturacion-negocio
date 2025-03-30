<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use App\Models\Vendedor;
use App\Models\Venta;
class DetallePedidoController extends Controller
{
    public function index()
    {
        return response()->json(DetallePedido::with('pedido', 'producto')->get(), 200);
    }

    
    public function store(Request $request)
{
    // Validar la petición
    $request->validate([
        'idPedido' => 'required|exists:pedido,id', // Verifica que el id del pedido exista
        'productos' => 'required|array', // Asegura que se pasen productos
        'productos.*.idProducto' => 'required|exists:producto,id', // Verifica que los productos existen
        'productos.*.cantidad' => 'required|integer|min:1', // Verifica que la cantidad sea válida
        'estado_pedido' => 'required|in:para llevar,para mesa', // Verifica el estado del pedido
    ]);

    // Obtener el pedido
    $pedido = Pedido::find($request->idPedido);

    // Inicializar el total del pedido
    $totalPedido = 0;

    // Iterar sobre cada producto
    foreach ($request->productos as $productoData) {
        $producto = Producto::find($productoData['idProducto']);
        $cantidad = $productoData['cantidad'];

        // Calcular el subtotal de cada producto
        $subtotal = $producto->precio * $cantidad;

        // Crear un nuevo detalle de pedido
        $detalle = DetallePedido::create([
            'idPedido' => $request->idPedido,
            'idProducto' => $producto->id,
            'cantidad' => $cantidad,
            'estado_pedido' => $request->estado_pedido,
            'subtotal' => $subtotal,
            'total' => $subtotal, // El total por producto es igual al subtotal por ahora
        ]);

        // Acumular el subtotal al total del pedido
        $totalPedido += $subtotal;
    }

    // Después de crear los detalles del pedido, registrar la venta automáticamente
    $venta = Venta::create([
        'idPedido' => $request->idPedido,
        'idVendedor' => $request->idVendedor, // Se asume que el vendedor está en la petición
        'total' => $totalPedido, // El total de la venta es la suma de los subtotales
        'fecha_venta' => now(), // Fecha actual
    ]);

    // Retornar la respuesta con la venta registrada
    return response()->json([
        'message' => 'Detalle de pedido registrado y venta realizada',
        'data' => $venta
    ], 201);
}

    public function show($id)
    {
        $detallePedido = DetallePedido::with('pedido', 'producto')->find($id);

        if (!$detallePedido) {
            return response()->json(['error' => 'Detalle del pedido no encontrado'], 404);
        }

        return response()->json($detallePedido, 200);
    }

    public function update(Request $request, $id)
    {
        $detallePedido = DetallePedido::find($id);

        if (!$detallePedido) {
            return response()->json(['error' => 'Detalle del pedido no encontrado'], 404);
        }

        $detallePedido->update($request->all());

        return response()->json($detallePedido, 200);
    }

    public function destroy($id)
    {
        $detallePedido = DetallePedido::find($id);

        if (!$detallePedido) {
            return response()->json(['error' => 'Detalle del pedido no encontrado'], 404);
        }

        $detallePedido->delete();

        return response()->json(['message' => 'Detalle del pedido eliminado correctamente'], 200);
    }
}
