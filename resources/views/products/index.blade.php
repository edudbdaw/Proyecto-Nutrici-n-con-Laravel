<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Alimentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ZONA DE MENSAJES --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">¡Éxito!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    {{-- FIN ZONA DE MENSAJES --}}

                    {{-- Aquí empieza tu tabla --}}
                    <table class="min-w-full...
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Tabla de Productos --}}

                    
                    <table class="min-w-full border-collapse block md:table">
                        <thead class="block md:table-header-group">
                            <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
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
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Nombre</span>
                                        {{ $product->name }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Categoría</span>
                                        {{-- AQUÍ USAMOS LA RELACIÓN QUE ACABAMOS DE CREAR --}}
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Calorías</span>
                                        {{ number_format($product->calories, 1) }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Dueño</span>
                                        @if($product->user_id)
                                            <span class="text-green-600 font-bold">Mío</span>
                                        @else
                                            <span class="text-gray-500">Público (API)</span>
                                        @endif
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                        <span class="inline-block w-1/3 md:hidden font-bold">Acciones</span>

                                        {{-- LÓGICA DE PROTECCIÓN VISUAL --}}
                                        {{-- Solo muestro el botón si el dueño SOY YO --}}
                                        @if($product->user_id === Auth::id())
                                            <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                Editar
                                            </a>

                                            {{-- Botón BORRAR --}}
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('¿Seguro que quieres borrar este alimento?');">
                                                @csrf
                                                @method('DELETE')
                                                
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                        X
                                                    </button>
                                                
                                                
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs italic">No se puede editar</span>
                                        @endif
                                        

                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Paginación (Los botones de Siguiente/Anterior) --}}
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>