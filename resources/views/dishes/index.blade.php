<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Mis Platos</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        
                {{-- Botón para crear nuevo plato --}}
                <a href="{{ route('dishes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-6 inline-block">
                    Crear Nuevo Plato
                </a>
                
                {{-- Grid de Platos --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @forelse($dishes as $dish)
                        <div class="border p-4 rounded shadow hover:bg-gray-50 transition">
                            <h3 class="font-bold text-lg mb-1">{{ $dish->name }}</h3>
                            
                            <div class="text-sm text-gray-600 mb-2">
                                <p>{{ $dish->products->count() }} Ingredientes</p>
                                <p class="font-bold text-green-600">
                                    {{ number_format($dish->total_calories, 1) }} Kcal
                                </p>
                            </div>
                            
                            <div class="mt-4 flex gap-3 items-center border-t pt-3">
                                {{-- Botón para entrar a la cocina --}}
                                <a href="{{ route('dishes.show', $dish) }}" class="text-blue-600 hover:underline font-semibold text-sm">
                                    Gestionar Ingredientes
                                </a>

                                {{-- Botón Borrar --}}
                                <form action="{{ route('dishes.destroy', $dish) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este plato?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 text-sm">Borrar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500 py-4">
                            No tienes platos creados todavía. ¡Crea el primero!
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>