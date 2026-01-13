<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // VER EL CALENDARIO (Agrupado por días)
    public function index()
    {
        // 1. Sacamos todos los menús del usuario ordenados por fecha
        $menus = Menu::where('user_id', Auth::id())
                     ->with('dish.products') // Carga ansiosa para que vaya rápido
                     ->orderBy('date', 'desc')
                     ->get();

        // 2. AGRUPAMOS por fecha
        // Esto crea una estructura: ['2025-01-14' => [Plato1, Plato2], '2025-01-15' => ...]
        $groupedMenus = $menus->groupBy('date');

        return view('menus.index', compact('groupedMenus'));
    }

    // FORMULARIO PARA AÑADIR AL CALENDARIO
    public function create()
    {
        // Necesitamos la lista de platos del usuario para que elija
        $dishes = Dish::where('user_id', Auth::id())->get();
        return view('menus.create', compact('dishes'));
    }

    // GUARDAR EN EL CALENDARIO
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'dish_id' => 'required|exists:dishes,id',
        ]);

        // Verificamos que el plato sea suyo (Seguridad extra)
        $dish = Dish::find($request->dish_id);
        if($dish->user_id !== Auth::id()) abort(403);

        Menu::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'dish_id' => $request->dish_id
        ]);

        return redirect()->route('menus.index')->with('success', 'Plato añadido al calendario.');
    }
    
    // BORRAR DEL CALENDARIO
    public function destroy(Menu $menu)
    {
        if($menu->user_id !== Auth::id()) abort(403);
        $menu->delete();
        return back()->with('success', 'Eliminado del menú.');
    }
}