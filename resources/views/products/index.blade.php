<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Alimentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. ZONA DE MENSAJES (Feedback al usuario) --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- 2. CABECERA CON BOTÓN DE AÑADIR --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Ingredientes Disponibles</h3>
                        
                        {{-- Botón Azul para Crear --}}
                        <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            + Añadir Alimento Propio
                        </a>
                    </div>

                    {{-- 3. TABLA DE PRODUCTOS --}}
                    <table class="min-w-full border-collapse block md:table">
                        <thead class="block md:table-header-group">
                            <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto md:relative">
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Nombre</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Categoría</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Calorías (Kcal)</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Dueño</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="block md:table-row-group">
                            @foreach ($products as $product)
                                <tr class="bg-white border border-grey-500 md:border-none block md:table-row hover:bg-gray-100">
                                    
                                    {{-- Nombre --}}
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Nombre</span>
                                        {{ $product->name }}
                                    </td>
                                    
                                    {{-- Categoría (Protegida con ?) --}}
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Categoría</span>
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                                            {{ $product->category?->name ?? 'Sin Categoría' }}
                                        </span>
                                    </td>
                                    
                                    {{-- Calorías --}}
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Calorías</span>
                                        {{ number_format($product->calories, 1) }}
                                    </td>
                                    
                                    {{-- Dueño --}}
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Dueño</span>
                                        @if($product->user_id === Auth::id())
                                            <span class="text-green-600 font-bold">Mío</span>
                                        @else
                                            <span class="text-gray-500">Público (API)</span>
                                        @endif
                                    </td>

                                    {{-- Acciones (Editar/Borrar) --}}
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Acciones</span>

                                        {{-- SOLO SI ES MÍO --}}
                                        @if($product->user_id === Auth::id())
                                            {{-- Botón EDITAR --}}
                                            <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                Editar
                                            </a>

                                            {{-- Botón BORRAR --}}
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block ml-1" onsubmit="return confirm('¿Seguro que quieres borrar este alimento?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                    X
                                                </button>
                                            </form>
                                        @else
                                            {{-- SI ES PÚBLICO --}}
                                            <span class="text-gray-400 text-xs italic">Bloqueado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- 4. PAGINACIÓN --}}
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>