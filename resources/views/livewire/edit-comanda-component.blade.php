<div class="p-4 rounded-xl shadow-md bg-gray-900 text-gray-100">

    <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b border-gray-800 py-3 md:py-2">
        <div class="w-full md:w-1/12 text-gray-300">{{ $comanda->id }}</div>
        <div class="w-full md:w-3/12 text-gray-100">{{ $comanda->stock->nombre ?? '—' }}</div>

        <!-- Cantidad -->
        <div class="w-full md:w-2/12 flex items-center justify-center gap-2">
            <button wire:click="decrementarCantidad({{ $comanda->id }})"
                    class="w-8 h-8 flex items-center justify-center bg-gray-800 text-gray-100 rounded-full hover:bg-gray-700 focus:outline-none">
                –
            </button>

            <input type="number"
                   wire:model.defer="cantidades.{{ $comanda->id }}"
                   wire:keydown.enter="guardarCantidad({{ $comanda->id }})"
                   class="w-16 text-center bg-gray-900 border-none text-gray-100 font-medium focus:outline-none"
                   min="0">

            <button wire:click="incrementarCantidad({{ $comanda->id }})"
                    class="w-8 h-8 flex items-center justify-center bg-gray-800 text-gray-100 rounded-full hover:bg-gray-700 focus:outline-none">
                +
            </button>
        </div>

        <!-- Nota -->
        <div class="w-full md:w-3/12 flex items-center gap-2">
            <input type="text"
                   wire:model.defer="notasArray.{{ $comanda->id }}"
                   wire:keydown.enter="guardarNota({{ $comanda->id }})"
                   class="w-full p-1 text-gray-900 bg-gray-100 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="{{ $comanda->notas }}">

            <button wire:click="guardarNota({{ $comanda->id }})"
                    class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none">
                Guardar
            </button>
        </div>

        <div class="w-full md:w-3/12 text-gray-200 truncate">{{ $comanda->notas }}</div>
        <div class="w-full md:w-2/12 text-gray-300">{{ $comanda->user->name }}</div>
        <div class="w-full md:w-1/12 text-gray-300">
            {{ $comanda->updated_at->ne($comanda->created_at)
                ? $comanda->updated_at->format('H:i')
                : $comanda->created_at->format('H:i') }}
        </div>

        <div class="w-full md:w-1/12 flex gap-2 mt-2 md:mt-0">
            <button wire:click="eliminar"
                    class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-white text-sm">Eliminar</button>
        </div>
    </div>

    {{-- Mensaje de acción --}}
    @if (session()->has('mensaje'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 1500)"
            x-show="show"
            class="mt-4 p-3 bg-green-700 text-green-100 rounded-lg text-sm"
        >
            {{ session('mensaje') }}
        </div>
    @endif
</div>
