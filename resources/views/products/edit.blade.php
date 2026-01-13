<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Alimento: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- OJO: La ruta ahora es UPDATE y le pasamos el producto --}}
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        
                        {{-- TRUCO HTML: Los navegadores solo entienden GET y POST.
                             Para hacer un UPDATE (PUT), Laravel usa esta "trampa": --}}
                        @method('PUT')

                        {{-- Nombre --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                            {{-- value: Ponemos lo que ya tenía el producto --}}
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        {{-- Categoría --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                            <select name="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{-- Si la categoría coincide con la del producto, ponle SELECTED --}}
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Calorías --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Calorías (Kcal):</label>
                            <input type="number" step="0.01" name="calories" value="{{ old('calories', $product->calories) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        {{-- RESTO DE CAMPOS (Proteínas, Grasas...) --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Proteínas:</label>
                                <input type="number" step="0.01" name="proteins" value="{{ old('proteins', $product->proteins) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Carbohidratos:</label>
                                <input type="number" step="0.01" name="carbohydrates" value="{{ old('carbohydrates', $product->carbohydrates) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Grasas:</label>
                                <input type="number" step="0.01" name="fats" value="{{ old('fats', $product->fats) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>

                        {{-- BOTONES --}}
                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Actualizar Producto
                            </button>
                            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-800">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>