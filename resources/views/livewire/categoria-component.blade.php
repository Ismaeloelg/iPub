<div class="h-165">
    <form wire:submit.prevent="guardarCategoria"
          class="m-auto bg-white rounded-3xl shadow-xl p-8 space-y-6 shadow ">

        <h1 class="text-4xl font-semibold ">
            Crear Categoría
        </h1>

        <div class="space-y-2">
            <label class="block text-gray-700 font-medium">Nombre de la categoría</label>

            <input type="text" wire:model="nombre"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition p-2.5"
                   placeholder="Ingrese un nombre">

        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white font-medium py-2.5 rounded-lg hover:bg-blue-700 transition shadow-md">
            Guardar Categoría
        </button>
    </form>


    <div class="rounded-3xl mt-4 bg-white h-76 overflow-y-auto shadow-lg border border-gray-200">

        <div class="text-xl font-semibold text-gray-700 text-center sticky top-0 bg-white py-3 border-b">
            Categorías disponibles
        </div>


        <div class="p-4 space-y-2">
            @if($categorias->isEmpty())
                <p class="text-gray-500 text-center py-4">No hay categorías registradas.</p>
            @else
                @foreach($categorias as $categoria)
                    <div wire:click="delete({{$categoria->id}})"
                         class="px-4 py-2 bg-gray-100 hover:bg-blue-100 rounded-lg text-gray-800 transition shadow-sm flex flex-col">
                        {{ $categoria->nombre }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div
            class="bg-green-100 border border-green-400 text-green-800 p-3 rounded-full shadow-md mt-4"
            role="alert">
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @elseif (session()->has('error'))
        <div
            class="bg-red-100 border border-red-400 text-red-800 p-3 rounded-full shadow-md mt-4"
            role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif
    @error('nombre')
    <div
        class="bg-red-100 border border-red-400 text-red-800 p-3 rounded-full shadow-md mt-4">
        <span class="font-medium">{{ $message }}</span>
    </div>
    @enderror

</div>

