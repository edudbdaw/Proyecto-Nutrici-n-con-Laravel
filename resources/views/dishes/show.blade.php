<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Cocinando: {{ $dish->name }}</h2>
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded font-bold">Total: {{ number_format($dish->total_calories, 1) }} Kcal</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- COLUMNA IZQ: LISTA DE INGREDIENTES --}}
            <div class="bg-white p-6 shadow rounded">
                <h3 class="font-bold text-lg mb-4">Ingredientes Añadidos</h3>
                @if($dish->products->isEmpty())
                    <p class="text-gray-500 italic">Tu plato está vacío. Añade algo.</p>
                @else
                    <ul>
                        @foreach($dish->products as $product)
                            <li class="flex justify-between items-center border-b py-2">
                                <div>
                                    <span class="font-bold">{{ $product->name }}</span>
                                    {{-- pivot->amount accede a la columna 'amount' de la tabla intermedia --}}
                                    <span class="text-sm text-gray-600">({{ $product->pivot->amount }} g)</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    {{-- CALCULO EN VIVO: (Kcal * Gramos / 100) --}}
                                    <span class="text-sm font-mono">{{ number_format(($product->calories * $product->pivot->amount)/100, 1) }} Kcal</span>
                                    
                                    {{-- Botón Quitar --}}
                                    <form action="{{ route('dishes.remove-product', [$dish, $product]) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 font-bold hover:text-red-700">x</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- COLUMNA DER: AÑADIR NUEVO --}}
            <div class="bg-white p-6 shadow rounded h-fit">
                <h3 class="font-bold text-lg mb-4">Añadir Ingrediente</h3>
                <form action="{{ route('dishes.add-product', $dish) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Producto:</label>
                        {{-- Select con buscador nativo simple --}}
                        <select name="product_id" class="w-full border p-2 rounded" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} ({{ number_format($product->calories, 0) }} Kcal/100g)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Cantidad (Gramos):</label>
                        <input type="number" name="amount" class="w-full border p-2 rounded" placeholder="ej: 100" required min="1">
                    </div>

                    <button class="w-full bg-green-500 hover:bg-green-600 text-black font-bold py-2 rounded">
                        + Añadir a la Olla
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>