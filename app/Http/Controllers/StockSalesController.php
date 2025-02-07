<?php

namespace App\Http\Controllers;

use App\Models\StockSales;
use App\Models\Product;
use App\Models\Store;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class StockSalesController extends Controller
{
    // Mostrar el formulario para agregar un nuevo StockSale
    public function create()
    {
        $products = Product::all();
        $stores = Store::all();


        return view('stock_sales.create', compact('products', 'stores'));
    }

    // Guardar un nuevo StockSale
    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
            'created_by' => 'required|integer', // Aquí puedes colocar la lógica para obtener el usuario que crea el registro
        ]);

        // Crear el nuevo StockSale
        StockSales::create([
            'quantity' => $request->quantity,
            'product_id' => $request->product_id,
            'store_id' => $request->store_id,
            'created_by' => $request->created_by,
            'updated_by' => $request->created_by, // Asegúrate de actualizar esto cuando edites el registro
        ]);

        return redirect()->route('stock-sales.index')->with('success', 'StockSale created successfully.');
    }

    // Mostrar el formulario para editar un StockSale
    public function edit($id)
    {
        $stockSale = StockSales::findOrFail($id);
        $products = Product::all();
        $stores = Store::all();


        return view('stock_sales.edit', compact('stockSale', 'products', 'stores'));
    }

    // Actualizar un StockSale existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1' // Aquí puedes colocar la lógica para obtener el usuario que edita el registro
        ]);

        // Buscar el StockSale a editar
        $stockSale = StockSales::findOrFail($id);

        // Actualizar el StockSale
        $stockSale->quantity = $request->quantity;

        $stockSale->save();

        return redirect()->back()->with('success', 'Cantidad de stock actualizada correctamente.');
    }

    // Eliminar un StockSale
    public function destroy($id)
    {
        $stockSale = StockSales::findOrFail($id);
        $stockSale->delete();

        return redirect()->route('stock-sales.index')->with('success', 'StockSale deleted successfully.');
    }


    public function updateStock(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'stockId' => 'required|exists:stock_sales,id',
            'quantity' => 'required|integer|min:1', // Asegura que la cantidad sea un número positivo

        ]);

        // Encontrar el registro de StockSales por ID
        $stock = StockSales::find($request->stockId);

        // Actualizar la cantidad
        $stock->update([
            'quantity' => $request->quantity,
            'updated_by' => auth()->id(), // Se puede registrar el ID del usuario que realiza la actualización si usas autenticación
        ]);

        // Retornar una respuesta, por ejemplo, redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Stock actualizado exitosamente.');
    }

    // Método para agregar Stock
    public function addStock(Request $request)
    {
        // Validar la entrada, incluyendo todos los campos requeridos
        $request->validate([
            'product_id' => 'required|exists:products,id',  // El producto debe existir
            'store_id' => 'required|exists:stores,id',  // La tienda debe existir
            'quantity' => 'required|integer|min:1',  // Cantidad debe ser un número entero positivo

        ]);

        // Crear un nuevo registro de StockSales con todos los campos
        StockSales::create([
            'product_id' => $request->product_id,
            'store_id' => $request->store_id,
            'quantity' => $request->quantity,
            'created_by' => auth()->id(),  // El ID del usuario que crea el registro
            'updated_by' => auth()->id(),  // El ID del usuario que actualiza el registro
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('product-list')->with('success', 'Stock agregado correctamente.');
    }
}
