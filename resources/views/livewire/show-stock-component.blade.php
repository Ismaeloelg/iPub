<div>
    @if($productos->isEmpty())
        <p class="text-gray-500">No hay productos registrados en el stock.</p>
    @else
        <div class="bg-gray-600 rounded-3xl p-5 shadow-2xl h-170">
            <div class="bg-white rounded-2xl p-1">

                <div class="overflow-y-auto max-h-140 rounded-lg text-black ">
                    <table class="w-full table-auto border border-gray-200 ">
                        <thead class="bg-blue-500 sticky top-0 ">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">#</th>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">Nombre</th>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">Unidades</th>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">Categoría</th>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">Precio Venta</th>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">Precio Compra</th>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">Descripción</th>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">Editar</th>
                            <th class="px-4 py-2 text-left text-sm text-gray-700">Eliminar</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($productos as $producto)
                            <tr class="odd:bg-blue-100">
                                <td class="px-4 py-2 text-sm">{{ $producto->id }}</td>
                                <td class="px-4 py-2 text-sm">{{ $producto->nombre }}</td>
                                <td class="px-4 py-2 text-sm">{{ $producto-> unidades }}</td>
                                <td class="px-4 py-2 text-sm">{{  $producto-> categoria->nombre  }}</td>
                                <td class="px-4 py-2 text-sm">${{ number_format($producto->precio_venta, 2) }}</td>
                                <td class="px-4 py-2 text-sm">${{ number_format($producto->precio_compra, 2) }}</td>
                                <td class="px-4 py-2 text-sm">{{$producto-> descripcion ?? 'Sin descripción'}}</td>
                                <td class="px-4 py-2 text-sm">
                                    <div class=" item-center">
                                        <a href="{{ route('editStock', ['productoId' => $producto->id]) }}"
                                           class="inline-block px-6 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600 transition">
                                            Editar
                                        </a>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <div class="item-center">
                                        <button wire:click="delete({{ $producto->id }})"
                                                class="inline-block px-6 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600 transition">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('stock') }}"
                   class="inline-block px-6 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600 transition">
                    Insertar Nuevo Producto
                </a>
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
</div>
