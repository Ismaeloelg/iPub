<div class="bg-gray-900 flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full ">

        <h1 class="text-3xl font-extrabold text-center text-white">Insertar Producto en el Stock</h1>
        <form wire:submit.prevent="guardarProducto"
              class="bg-gray-800 rounded-2xl shadow-xl p-5 space-y-5 text-gray-100">

            <div>
                <label class="block mb-1">Nombre Producto</label>
                <input type="text" wire:model="nombre"
                       class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2"
                       placeholder="Nombre Producto">
                @error('nombre')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block mb-1">Unidades</label>
                <input type="number" wire:model="unidades"
                       class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2"
                       placeholder="Número de unidades">
                @error('unidades')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block mb-1">Precio Venta</label>
                <input type="decimal" wire:model="precio_venta"
                       class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2"
                       placeholder="Precio Venta">
                @error('precio_venta')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block mb-1">Precio Compra</label>
                <input type="decimal" wire:model="precio_compra"
                       class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2"
                       placeholder="Precio Compra">
                @error('precio_compra')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block mb-1">Descripción</label>
                <textarea wire:model="descripcion"
                          class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2 h-24"
                          placeholder="Descripción del producto"></textarea>
            </div>

            <div>
                <label class="block mb-1">Categoria</label>
                <select wire:model="categoria_id"
                        class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2">
                    <option value="">Seleccionar una categoria</option>
                    @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}"> {{$categoria->nombre}}</option>
                    @endforeach
                </select>
                @error('categoria_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 transition-colors py-3 rounded-lg font-semibold text-white">
                Guardar Producto
            </button>
        </form>

    </div>
</div>
