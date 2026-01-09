<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg text-blue-600">Nombre del Producto:</h3>
                    {{-- Mostramos el nombre simple --}}
                    @dump($producto)

                    <h3 class="font-bold text-lg text-red-600 mt-4">Ficha Nutricional (Lo complejo):</h3>
                    {{-- Mostramos el objeto gigante con los nutrientes --}}
                    @dump($nutrientes)
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
