<?php


namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use App\Models\Vendedor;
use Illuminate\Support\Facades\Validator;
use App\Models\Venta;
class DetallePedidoController 
{
    public function index()
    {
        return response()->json(DetallePedido::with('pedido', 'producto')->get(), 200);
    }

public function store(Request $request)
{
    // Validación del request
    $validator = Validator::make($request->all(), [
        'idPedido' => 'required|exists:pedido,id',
        'idVendedor' => 'required|exists:vendedor,id',
        'estado_pedido' => 'required|in:para llevar,para mesa',
        'productos' => 'required|array|min:1',
        'productos.*.idProducto' => 'required|exists:producto,id',
        'productos.*.cantidad' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Obtener el pedido y su sucursal
    $pedido = Pedido::findOrFail($request->idPedido);
    $idSucursal = $pedido->idSucursal;

    $totalPedido = 0;

    foreach ($request->productos as $productoData) {
        $producto = Producto::findOrFail($productoData['idProducto']);
        $cantidad = $productoData['cantidad'];
        $precioUnitario = $producto->precio;
        $totalPorProducto = $precioUnitario * $cantidad;

        DetallePedido::create([
            'idPedido' => $pedido->id,
            'idProducto' => $producto->id,
            'cantidad' => $cantidad,
            'estado_pedido' => $request->estado_pedido,
            'subtotal' => $precioUnitario,
            'total' => $totalPorProducto,
        ]);

        $totalPedido += $totalPorProducto;
    }

    // Crear la venta con la sucursal obtenida automáticamente
    $venta = Venta::create([
        'idPedido' => $pedido->id,
        'idVendedor' => $request->idVendedor,
        'total' => $totalPedido,
        'fecha_venta' => now(),
        'idSucursal' => $idSucursal
    ]);

    return response()->json([
        'message' => 'Detalle de pedido registrado y venta realizada exitosamente',
        'venta' => $venta
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


    public function update(Request $request, $idPedido)
{
    // Validación
    $validator = Validator::make($request->all(), [
        'idVendedor' => 'required|exists:vendedor,id',
        'estado_pedido' => 'required|in:para llevar,para mesa',
        'productos' => 'required|array|min:1',
        'productos.*.idProducto' => 'required|exists:producto,id',
        'productos.*.cantidad' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Buscar el pedido
    $pedido = Pedido::find($idPedido);
    if (!$pedido) {
        return response()->json(['message' => 'Pedido no encontrado'], 404);
    }

    $idSucursal = $pedido->idSucursal;

    // Borrar detalles anteriores del pedido
    DetallePedido::where('idPedido', $pedido->id)->delete();

    $totalPedido = 0;

    foreach ($request->productos as $productoData) {
        $producto = Producto::findOrFail($productoData['idProducto']);
        $cantidad = $productoData['cantidad'];
        $precioUnitario = $producto->precio;
        $totalPorProducto = $precioUnitario * $cantidad;

        DetallePedido::create([
            'idPedido' => $pedido->id,
            'idProducto' => $producto->id,
            'cantidad' => $cantidad,
            'estado_pedido' => $request->estado_pedido,
            'subtotal' => $precioUnitario,
            'total' => $totalPorProducto,
        ]);

        $totalPedido += $totalPorProducto;
    }

    // Actualizar o crear la venta
    $venta = Venta::where('idPedido', $pedido->id)->first();
    if ($venta) {
        // actualizar
        $venta->update([
            'idVendedor' => $request->idVendedor,
            'total' => $totalPedido,
            'fecha_venta' => now(),
            'idSucursal' => $idSucursal
        ]);
    } else {
        // si no existía, crear
        $venta = Venta::create([
            'idPedido' => $pedido->id,
            'idVendedor' => $request->idVendedor,
            'total' => $totalPedido,
            'fecha_venta' => now(),
            'idSucursal' => $idSucursal
        ]);
    }

    return response()->json([
        'message' => 'Pedido y venta actualizados exitosamente',
        'venta' => $venta
    ], 200);
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
