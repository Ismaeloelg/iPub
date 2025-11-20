<div class="m-5">

    <div class="flex gap-4 mb-4 justify-center text-2xl ">
        <button wire:click="cambiarPantalla('comanda')"
                class="font-semibold {{ $pantalla == 'comanda' ? 'text-blue-500' : 'text-gray-400' }}">
            Crear Comanda
        </button>

        <button wire:click="cambiarPantalla('registradas')"
                class="font-semibold {{ $pantalla == 'registradas' ? 'text-blue-500' : 'text-gray-400' }}">
            Comandas Registradas
        </button>
    </div>

    @if($pantalla == 'comanda')
        <div class="bg-gray-600 shadow-xl rounded-4xl p-5">
            <h2 class="text-2xl font-bold mb-6">Comanda - Mesa #{{ $mesa->id }}</h2>

            <div class="flex gap-6">

                {{-- PRODUCTOS --}}
                <div class="w-3/4">
                    <div class="grid grid-cols-5 gap-4">
                        @foreach($categorias as $categoria)
                            <div wire:click="verProductos({{ $categoria->id }})"
                                 class="p-3 rounded-2xl bg-purple-100 shadow-lg text-center border cursor-pointer transition hover:shadow-lg hover:bg-yellow-100 hover:ring-3 ring-purple-100 border-purple-100
                                 {{ $categoriaSeleccionada == $categoria->id ? ' bg-yellow-50 border-yellow-300 ring-4 ring-yellow-200 ' : 'border-gray-200' }}">
                                <h3 class="font-bold text-black text-2xl">{{ $categoria->nombre }}</h3>
                            </div>
                        @endforeach
                    </div>

                    @if($categoriaSeleccionada)
                        <div class="rounded-lg shadow p-1">
                            @if($productosFiltrados->isNotEmpty())
                                <div class="grid grid-cols-6 gap-4">
                                    @foreach($productosFiltrados as $producto)
                                        <div class="p-4 border rounded-lg hover:shadow transition cursor-pointer"
                                             wire:click="agregarProducto({{ $producto->id }})">
                                            <h4 class="font-medium">{{ $producto->nombre }}</h4>
                                            <p class="text-sm text-gray-600">${{ number_format($producto->precio_venta, 2) }}</p>
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

                {{-- TICKET --}}
                <div class="w-1/4">
                    @if($ticket)
                        @livewire('ticket-mesas-component', ['ticketId' => $ticket->id], key('ticket-'.$ticket->id))
                    @endif
                </div>

            </div>
        </div>
    @else

        {{-- COMANDAS REGISTRADAS --}}
        <div class="bg-gray-600 shadow-xl rounded-4xl max-h-[750px] overflow-y-auto">
            <h3 class="text-2xl font-semibold m-auto mb-4 sticky top-0 bg-gray-50 shadow w-full rounded-3xl p-5 text-center">
                Comandas registradas
            </h3>

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
