<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Planificar Comida</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8"><div class="bg-white p-6 rounded shadow">
        
        <form action="{{ route('menus.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block font-bold mb-2">Fecha:</label>
                {{-- value: Por defecto pone HOY --}}
                <input type="date" name="date" class="border p-2 w-full rounded" required value="{{ date('Y-m-d') }}">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-2">Elige el Plato:</label>
                <select name="dish_id" class="border p-2 w-full rounded" required>
                    @foreach($dishes as $dish)
                        <option value="{{ $dish->id }}">{{ $dish->name }} ({{ number_format($dish->total_calories, 0) }} Kcal)</option>
                    @endforeach
                </select>
            </div>

            <button class="bg-indigo-500 text-white px-4 py-2 rounded font-bold">Añadir al Calendario</button>
        </form>

    </div></div></div>
</x-app-layout>