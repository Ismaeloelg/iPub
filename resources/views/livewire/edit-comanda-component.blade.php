<div class="p-4 sm:p-5 md:p-6 lg:p-8 rounded-2xl shadow-2xl bg-gray-900 text-gray-100">
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

    <div class="flex flex-col md:flex-row items-start md:items-center justify-center border-b border-gray-800 py-10 md:py-2 ml-20">

        <!-- Producto -->
        <div class="w-full md:w-3/12 text-gray-100 md:text-left text-center pl-4 md:pl-0">{{ $comanda->stock->nombre ?? '—' }}</div>

        <!-- Cantidad -->
        <div class="w-full md:w-2/12 flex items-center justify-center gap-2 mt-3 md:mt-0">
            <button wire:click="decrementarCantidad({{ $comanda->id }})"
                    class="w-8 h-8 flex items-center justify-center bg-gray-800 text-gray-100 rounded-full hover:bg-gray-700 focus:outline-none">
                –
            </button>

            <input type="number"
                   wire:model.defer="cantidades.{{ $comanda->id }}"
                   wire:keydown.enter="guardarCantidad({{ $comanda->id }})"
                   class="w-16 text-center bg-gray-900 border-none text-gray-100 font-medium focus:outline-none" min="0">

            <button wire:click="incrementarCantidad({{ $comanda->id }})"
                    class="w-8 h-8 flex items-center justify-center bg-gray-800 text-gray-100 rounded-full hover:bg-gray-700 focus:outline-none">
                +
            </button>
        </div>

        <!-- Nota -->
        <div class="w-full md:w-3/12 flex items-center gap-2 mt-3 md:mt-0 px-10 ml-40">
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

        <!-- Notas -->
        <div class="w-full md:w-3/12 text-gray-200 truncate text-center md:text-left mt-3 md:mt-0">
            {{ $comanda->notas }}
        </div>

        <!-- Usuario -->
        <div class="w-full md:w-2/12 text-gray-300 text-center md:text-left mt-3 md:mt-0">
            {{ $comanda->user->name }}
        </div>

        <!-- Hora -->
        <div class="w-full md:w-1/12 text-gray-300 text-center md:text-left mt-3 md:mt-0">
            {{ $comanda->updated_at->ne($comanda->created_at)
                ? $comanda->updated_at->format('H:i')
                : $comanda->created_at->format('H:i') }}
        </div>

        <!-- Eliminar -->
        <div class="w-full md:w-1/12 flex gap-2 mt-2 md:mt-0 mr-4 md:mr-0">
            <button wire:click="eliminar"
                    class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-white text-sm transition-all">
                Eliminar
            </button>
        </div>
    </div>


</div>
