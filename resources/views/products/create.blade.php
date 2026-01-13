<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Alimento
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- INICIO DEL FORMULARIO --}}
                    {{-- action: ¿A dónde van los datos? A la ruta 'store' --}}
                    {{-- method: POST (porque vamos a enviar/guardar info) --}}
                    <form action="{{ route('products.store') }}" method="POST">
                        
                        {{-- 🛡️ ESCUDO DE SEGURIDAD (Obligatorio en Laravel) --}}
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Alimento:</label>
                            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Ej: Pastel de la Abuela">
                        </div>

                        {{-- Categoría (Desplegable) --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                            <select name="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Calorías --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Calorías (Kcal):</label>
                            <input type="number" step="0.01" name="calories" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        {{-- Proteínas (Ejemplo de otro macro) --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Proteínas (g):</label>
                            <input type="number" step="0.01" name="proteins" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="0">
                        </div>

                        {{-- Carbohidratos --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Carbohidratos (g):</label>
                            <input type="number" step="0.01" name="carbohydrates" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="0">
                        </div>

                        {{-- Grasas --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Grasas Totales (g):</label>
                            <input type="number" step="0.01" name="fats" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="0">
                        </div>

                        {{-- Fibra --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Fibra (g):</label>
                            <input type="number" step="0.01" name="fiber" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="0">
                        </div>

                        {{-- BOTÓN GUARDAR --}}
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded border focus:outline-none focus:shadow-outline">
                                Guardar Producto
                            </button>
                        </div>
                    </form>
                    {{-- FIN DEL FORMULARIO --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>