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
        // LÓGICA DE NEGOCIO (REQUISITO DEL PROYECTO):
        // "Debemos ver los productos preestablecidos (públicos) Y los propios del usuario."

        // Traducimos esto a Eloquent:
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
