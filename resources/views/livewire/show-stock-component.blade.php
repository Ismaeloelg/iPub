<div>
    <div class="m-5">


        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-800 p-3 rounded-full shadow-md mt-4"
                 role="alert">
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        @elseif (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 p-3 rounded-full shadow-md mt-4" role="alert">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    @if($productos->isEmpty())
        <div
            class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-3xl shadow-md border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">No hay productos disponibles</h2>
            <p class="text-gray-500 text-center px-4">
                Actualmente no tienes productos registrados en el stock.
                Haz clic en "Insertar Nuevo Producto" para agregar tu primer producto.
            </p>
            <a href="{{ route('stock') }}"
               class="mt-4 inline-block px-6 py-2 bg-green-500 text-white font-medium rounded-4xl hover:bg-green-600 transition">
                Insertar Nuevo Producto
            </a>
        </div>
    @else
        <div class="bg-gray-600 rounded-3xl p-5 shadow-2xl h-170">
            <div class="bg-white rounded-2xl p-1">
                <div class="overflow-y-auto max-h-140 rounded-lg text-black">
                    <table class="w-full table-auto border border-gray-200">
                        <thead class="bg-blue-500 sticky top-0">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Unidades</th>
                            <th>Categoría</th>
                            <th>Precio Venta</th>
                            <th>Precio Compra</th>
                            <th>Descripción</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($productos as $producto)
                            <tr class="odd:bg-blue-100">
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->unidades }}</td>
                                <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                <td>${{ number_format($producto->precio_venta, 2) }}</td>
                                <td>${{ number_format($producto->precio_compra, 2) }}</td>
                                <td>{{ $producto->descripcion ?? 'Sin descripción' }}</td>
                                <td>
                                    <a href="{{ route('editStock', ['productoId' => $producto->id]) }}"
                                       class="inline-block px-6 py-2 text-white bg-green-500 rounded-4xl hover:bg-green-600 transition">
                                        Editar
                                    </a>
                                </td>
                                <td>
                                    <button wire:click="delete({{ $producto->id }})"
                                            class="inline-block px-6 py-2 text-white bg-red-500 rounded-4xl hover:bg-red-600 transition">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botón Insertar Nuevo Producto -->
            <div class="mt-4 text-center">
                <a href="{{ route('stock') }}"
                   class="inline-block px-6 py-3 text-white bg-green-500 rounded-4xl hover:bg-green-600 hover:scale-110 transition font-semibold">
                    Insertar Nuevo Producto
                </a>
            </div>
            <!-- Botones de acciones -->
            <div class="mt-6 flex flex-col md:flex-row justify-center items-center gap-4">

                <button wire:click="exportExcel"
                        class="w-full md:w-auto px-6 py-3 text-white bg-gray-700 rounded-4xl hover:bg-gray-800 transition hover:scale-110 font-semibold">
                    Exportar Stock a Excel
                </button>



                <form wire:submit.prevent="importExcel" enctype="multipart/form-data"
                      class="flex flex-col md:flex-row items-center gap-2 w-full md:w-auto">
                    <button type="submit"
                            class="px-6 py-3 text-white bg-blue-700 rounded-4xl hover:bg-blue-800 hover:scale-110 transition font-semibold">
                        Importar Excel
                    </button>
                    <input type="file" wire:model="excelFile"
                           class="p-2 rounded border border-gray-300 text-gray-700">
                    @error('excelFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </form>
            </div>


        </div>
    @endif


</div>
