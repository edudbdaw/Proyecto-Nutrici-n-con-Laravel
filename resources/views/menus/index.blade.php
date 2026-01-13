<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Mi Calendario Nutricional</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <a href="{{ route('menus.create') }}" class="bg-indigo-500 text-black px-4 py-2 rounded mb-6 inline-block">Planificar Nueva Comida</a>

        <div class="space-y-6">
            @foreach($groupedMenus as $date => $menuItems)
                {{-- CÁLCULO DEL TOTAL DEL DÍA --}}
                @php
                    $totalCaloriesDay = $menuItems->sum(function($item) {
                        return $item->dish->total_calories; 
                    });
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    {{-- CABECERA DEL DÍA --}}
                    <div class="bg-gray-100 px-6 py-3 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-gray-700">
                            {{ \Carbon\Carbon::parse($date)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </h3>
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">
                            Total Día: <strong>{{ number_format($totalCaloriesDay, 0) }} Kcal</strong>
                        </span>
                    </div>

                    {{-- LISTA DE PLATOS DE ESE DÍA --}}
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ul class="list-disc pl-5">
                            @foreach($menuItems as $item)
                                <li class="mb-2 flex justify-between items-center">
                                    <span>
                                        <strong>{{ $item->dish->name }}</strong>
                                        <span class="text-gray-500 text-sm">({{ number_format($item->dish->total_calories, 0) }} Kcal)</span>
                                    </span>
                                    
                                    {{-- Botón Quitar --}}
                                    <form action="{{ route('menus.destroy', $item) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 text-sm hover:underline">Quitar</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach

            @if($groupedMenus->isEmpty())
                <div class="text-center text-gray-500 py-10">
                    No tienes comidas planificadas. ¡Empieza ahora!
                </div>
            @endif
        </div>

    </div></div>
</x-app-layout>