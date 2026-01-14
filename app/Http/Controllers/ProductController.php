<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // "Debemos ver los productos preestablecidos (públicos) Y los propios del usuario."
        // "Dame los productos donde 'user_id' sea NULL (Públicos) 
        //  O donde 'user_id' sea el ID del usuario conectado (user logged)."

        $products = Product::whereNull('user_id')
            ->orWhere('user_id', Auth::id())
            ->paginate(10); // Usamos paginación para no cargar 500 de golpe

        // Le pasamos la variable $products a la vista
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Buscamos todas las categorías para pasarlas al desplegable del formulario
        $categories = Category::all();
        
        // 2. Mostramos la vista del formulario y le enviamos las categorías
        return view('products.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN
        // Antes de guardar nada, comprobamos que los datos vengan bien.
        // Si algo falla, Laravel devuelve al usuario al formulario con los errores automáticamente.
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id', // Que la categoría exista de verdad en la tabla categories
            'calories'      => 'required|numeric|min:0',
            'proteins'      => 'nullable|numeric|min:0',
            'carbohydrates' => 'nullable|numeric|min:0',
            'fats'          => 'nullable|numeric|min:0',
            'fiber'         => 'nullable|numeric|min:0',
        ]);

        
        // Nosotros lo inyectamos aquí. "El dueño es el que está logueado".
        $validated['user_id'] = Auth::id();

        // 3. GUARDAR EN BBDD 
        
        Product::create($validated);

        // 4. REDIRECCIÓN 
        // Una vez guardado, mandamos al usuario a la lista y le mostramos un mensajito.
        return redirect()->route('products.index')
                        ->with('success', '¡Alimento creado correctamente!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        
        // Si el producto del usuario , prohíbo la entrada.
        if ($product->user_id !== Auth::id()) {
            // Abortar con error 403 (Prohibido)
            abort(403, 'No tienes permiso para editar este alimento.');
        }

        // 2. Necesitamos las categorías para el desplegable (igual que en create)
        $categories = Category::all();

        // 3. Pasamos el producto y las categorías a la vista
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        // Aunque ocultemos el botón, un hacker puede enviar la petición por Postman.
        // Verificamos de nuevo que el producto sea del usuairo logueado.
        if ($product->user_id !== Auth::id()) {
            abort(403, 'No toques lo que no es tuyo.');
        }

        // 2. VALIDACIÓN (Igual que en store)
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'calories'      => 'required|numeric|min:0',
            'proteins'      => 'nullable|numeric|min:0',
            'carbohydrates' => 'nullable|numeric|min:0',
            'fats'          => 'nullable|numeric|min:0',
            
        ]);

        // 3. ACTUALIZAR
        // El método update() coge el array y cambia solo los campos que vienen.
        $product->update($validated);

        // 4. VOLVER AL LISTADO
        return redirect()->route('products.index')
                        ->with('success', '¡Producto actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 1. SEGURIDAD: Solo borras lo del usuario logueado
        if ($product->user_id !== Auth::id()) {
            abort(403, 'No puedes borrar productos de otros.');
        }

        // 2. BORRAR
        $product->delete();

        // 3. VOLVER
        return redirect()->route('products.index')
                        ->with('success', 'Producto eliminado correctamente.');
    }
}
