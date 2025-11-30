<div class="max-w-xl mx-auto p-6 bg-gray-900 ">
    <form wire:submit.prevent="guardarCategoria"
          class="bg-gray-800 rounded-2xl shadow-lg p-6 space-y-4">
        <h1 class="text-3xl font-bold text-white text-center">Crear Categoría</h1>

        <input type="text" wire:model.defer="nombre"
               placeholder="Nombre de la categoría"
               class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold p-3 rounded-lg transition">
            Guardar
        </button>

        @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </form>

    <div class="mt-6 bg-gray-800 rounded-2xl shadow-lg max-h-64 overflow-y-auto">
        <h2 class="text-xl font-semibold text-white p-3 border-b border-gray-700 text-center">Categorías</h2>
        <div class="divide-y divide-gray-700">
            @forelse($categorias as $categoria)
                <div class="flex justify-between items-center p-3 hover:bg-gray-700 transition text-white">
                    <div>
                        <span class="font-semibold">{{ $categoria->id }}.</span>
                        {{ $categoria->nombre }}
                    </div>
                    <button wire:click="delete({{ $categoria->id }})"
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm transition"
                            onclick="confirm('¿Estás seguro de eliminar esta categoría?') || event.stopImmediatePropagation()">
                        Eliminar
                    </button>
                </div>
            @empty
                <p class="text-gray-400 text-center p-4">No hay categorías registradas.</p>
            @endforelse
        </div>
    </div>

@if(session()->has('message'))
        <p class="mt-4 text-green-400 text-center">{{ session('message') }}</p>
    @endif
</div>
