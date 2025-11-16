<div class="m-5">

    <div class="flex gap-4 mb-4 justify-center text-2xl ">
        <button wire:click="cambiarPantalla('comanda')"
                class="font-semibold
        {{ $pantalla == 'comanda' ? 'text-blue-500' : 'text-gray-400' }}">
            Crear Comanda
        </button>

        <button wire:click="cambiarPantalla('registradas')"
                class="font-semibold
        {{ $pantalla == 'registradas' ? 'text-blue-500' : 'text-gray-400' }}">
            Comandas Registradas
        </button>
    </div>


    @if($pantalla== 'comanda')

        <div class="bg-gray-600 shadow-xl rounded-4xl p-5">
            <h2 class="text-2xl font-bold mb-6">Comanda - Mesa #{{ $mesa->id }}</h2>

            <div class="flex gap-6">
                <div class="w-3/4">

                    {{--CATEGORIAS--}}
                    <div class="grid grid-cols-5 gap-4">
                        @foreach($categorias as $categoria)
                            <div wire:click="verProductos({{ $categoria->id }})"
                                 class="p-3 rounded-2xl bg-purple-100 shadow-lg text-center border cursor-pointer transition hover:shadow-lg hover:bg-yellow-100 hover:ring-3 ring-purple-100 border-purple-100
                         {{ $categoriaSeleccionada == $categoria->id ? ' bg-yellow-50 border-yellow-300 ring-4 ring-yellow-200 ' : 'border-gray-200' }}">
                                <h3 class="font-bold text-black text-2xl">{{ $categoria->nombre }}</h3>
                            </div>
                        @endforeach
                    </div>

                    {{-- PRODUCTOS (STOCK) --}}
                    @if($categoriaSeleccionada)
                        <div class="rounded-lg shadow p-1">
                            @if($productosFiltrados->isNotEmpty())
                                <div class="grid grid-cols-6 gap-4">
                                    @foreach($productosFiltrados as $producto)
                                        <div class="p-4 border rounded-lg hover:shadow transition cursor-pointer"
                                             wire:click="agregarProducto({{ $producto->id }})">
                                            <h4 class="font-medium">{{ $producto->nombre }}</h4>
                                            <p class="text-sm text-gray-600">
                                                ${{ number_format($producto->precio_venta, 2) }}</p>
                                            <div class="mt-2 flex justify-between text-xs">
                                                <span class="bg-gray-200 px-2 py-1 rounded">{{ $producto->tipo }}</span>
                                                <span class="{{ $producto->unidades > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $producto->unidades }} unidades
                            </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-4">No hay productos disponibles en esta categoría.</p>
                            @endif
                        </div>
                    @endif

                </div>


                <div class="w-1/4">
                    {{-- Zona de Ticket --}}
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold mb-4 text-gray-800">Resumen del Ticket</h3>

                        @if($ticket && $ticket->mesa && $ticket->mesa->comandas->isNotEmpty())
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead>
                                <tr class="border-b">
                                    <th class="py-2">Producto</th>
                                    <th class="py-2 text-center">Cantidad</th>
                                    <th class="py-2 text-right">Precio U.</th>
                                    <th class="py-2 text-right">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $total = 0; @endphp
                                @foreach($ticket->mesa->comandas as $comanda)
                                    @php
                                        $subtotal = $comanda->precio * $comanda->cantidad;
                                        $total += $subtotal;
                                    @endphp
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2">{{ $comanda->stock->nombre ?? '—' }}</td>
                                        <td class="py-2 text-center">{{ $comanda->cantidad }}</td>
                                        <td class="py-2 text-right">${{ number_format($comanda->precio, 2) }}</td>
                                        <td class="py-2 text-right font-semibold">
                                            ${{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr class="border-t font-bold">
                                    <td colspan="3" class="py-2 text-right">Total:</td>
                                    <td class="py-2 text-right text-green-600">${{ number_format($total, 2) }}</td>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="mt-4">
                                    <button wire:click="cerrarMesa"
                                            class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
                                        Cerrar Mesa / Pagar
                                    </button>
                            </div>

                        @else
                            <p class="text-gray-500">No hay productos en la comanda todavía.</p>
                        @endif
                    </div>


                </div>

            </div>
        </div>
    @else

        {{--Zona Comanda Registradas--}}

        <div class="bg-gray-600 shadow-xl rounded-4xl max-h-[750px] overflow-y-auto">

            <div class=" ">
                <h3 class="text-2xl font-semibold m-auto  mb-4 sticky top-0 bg-gray-50 shadow w-full rounded-3xl p-5  text-center">
                    Comandas registradas </h3>
                <div class="grid gap-4">
                    @forelse($comandas as $comanda)
                        @livewire('edit-comanda-component', ['comanda' => $comanda], key($comanda->id))
                    @empty
                        <p class="text-gray-600">No hay comandas aún para esta mesa.</p>
                    @endforelse

                </div>
            </div>

            @endif

        </div>
</div>
