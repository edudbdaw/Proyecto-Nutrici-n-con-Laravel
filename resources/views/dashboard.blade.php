<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensaje de bienvenida --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    ¡Hola, <strong>{{ Auth::user()->name }}</strong>! ¿Qué quieres hacer hoy?
                </div>
            </div>

            {{-- GRID DE TARJETAS (3 Botones Grandes) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- TARJETA 1: ALIMENTOS --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6 border-b border-gray-200">
                        <div class="text-3xl mb-2"></div>
                        <h3 class="font-bold text-lg mb-2">Base de Alimentos</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Consulta la base de datos de alimentos, ve sus calorías o añade tus propios ingredientes personalizados.
                        </p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Ver Alimentos
                        </a>
                    </div>
                </div>

                {{-- TARJETA 2: PLATOS --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6 border-b border-gray-200">
                        <div class="text-3xl mb-2"></div>
                        <h3 class="font-bold text-lg mb-2">Cocina (Mis Platos)</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Crea recetas combinando ingredientes. El sistema calculará las calorías totales por ti.
                        </p>
                        <a href="{{ route('dishes.index') }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Gestionar Platos
                        </a>
                    </div>
                </div>

                {{-- TARJETA 3: CALENDARIO --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6 border-b border-gray-200">
                        <div class="text-3xl mb-2"></div>
                        <h3 class="font-bold text-lg mb-2">Mi Calendario</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Planifica tus comidas diarias y visualiza el resumen nutricional total de cada día.
                        </p>
                        <a href="{{ route('menus.index') }}" class="inline-block bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                            Ver Calendario
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>