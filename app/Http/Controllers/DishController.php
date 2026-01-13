<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DishController extends Controller
{
    // 1. LISTAR MIS PLATOS
    public function index()
    {
        $dishes = Dish::where('user_id', Auth::id())->get();
        return view('dishes.index', compact('dishes'));
    }

    // 2. FORMULARIO NOMBRE DEL PLATO
    public function create()
    {
        return view('dishes.create');
    }

    // 3. GUARDAR EL NOMBRE Y REDIRIGIR A "LA COCINA"
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $dish = Dish::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        // Nos vamos directos a la vista SHOW para añadir ingredientes
        return redirect()->route('dishes.show', $dish)
            ->with('success', 'Plato creado. ¡Ahora añade los ingredientes!');
    }

    // 4. LA COCINA (VER PLATO Y AÑADIR INGREDIENTES)
    public function show(Dish $dish)
    {
        if ($dish->user_id !== Auth::id()) abort(403);

        // Necesitamos la lista de productos para el desplegable (Igual que antes: Públicos + Míos)
        $products = Product::whereNull('user_id')
                    ->orWhere('user_id', Auth::id())
                    ->orderBy('name')
                    ->get();

        return view('dishes.show', compact('dish', 'products'));
    }

    // 5. ¡AÑADIR INGREDIENTE! (LA MAGIA) 🪄
    public function addProduct(Request $request, Dish $dish)
    {
        if ($dish->user_id !== Auth::id()) abort(403);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount'     => 'required|numeric|min:1', // Gramos
        ]);

        // Usamos la relación 'products()' y el método 'attach' para unir en la tabla intermedia
        // Le pasamos el ID del producto y un array con el campo extra 'amount'
        $dish->products()->attach($request->product_id, ['amount' => $request->amount]);

        return back()->with('success', 'Ingrediente añadido.');
    }

    // 6. BORRAR PLATO ENTERO
    public function destroy(Dish $dish)
    {
        if ($dish->user_id !== Auth::id()) abort(403);
        $dish->delete();
        return redirect()->route('dishes.index')->with('success', 'Plato eliminado.');
    }
    
    // 7. QUITAR UN INGREDIENTE (Opcional pero útil)
    public function removeProduct(Dish $dish, Product $product)
    {
         if ($dish->user_id !== Auth::id()) abort(403);
         $dish->products()->detach($product->id);
         return back()->with('success', 'Ingrediente quitado.');
    }
}