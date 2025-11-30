<div class="m-4">

    <div class="flex flex-col md:flex-row gap-4 mb-6 justify-center text-xl md:text-2xl">
        <button wire:click="cambiarPantalla('comanda')"
                class="font-semibold px-6 py-3 rounded-lg {{ $pantalla == 'comanda' ? 'text-blue-500' : 'text-gray-400' }}">
            Crear Comanda
        </button>

        <button wire:click="cambiarPantalla('registradas')"
                class="font-semibold px-6 py-3 rounded-lg {{ $pantalla == 'registradas' ? 'text-blue-500' : 'text-gray-400' }}">
            Comandas Registradas
        </button>
    </div>
    <div>

        @if (session()->has('mensaje'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 1500)"
                x-show="show"
                class="m-3 p-3 text-center bg-red-700 text-red-100 rounded-full text-sm">
                {{ session('mensaje') }}
            </div>
        @endif

        @if($pantalla == 'comanda')
            <div class="bg-gray-800 shadow-2xl rounded-4xl pt-10 p-6 md:p-8">

                <h2 class="text-4xl font-bold text-white mb-14 text-center">Mesa #{{ $mesa->id }}</h2>

                <div class="flex flex-col md:flex-row gap-8 m-4 md:m-6">

                    <div class="w-full md:w-3/4">
                        <div class="grid lg:grid-cols-3 2xl:grid-cols-6 gap-6 pb-5">
                            @foreach($categorias as $categoria)
                                {{-- CATEGORÍAS --}}
                                <div wire:click="verProductos({{ $categoria->id }})"
                                     class="p-4 bg-gray-900 rounded-2xl shadow-2xl cursor-pointer flex flex-col justify-between h-full border transition transform
                                        hover:scale-105 hover:bg-green-800
                                        {{ $categoriaSeleccionada == $categoria->id ? 'bg-green-800 border-blue-500' : 'border-gray-600 border-2' }}">
                                    <h3 class="font-bold text-white text-base sm:text-lg md:text-xl lg:text-2xl truncate break-words">
                                        {{ $categoria->nombre }}
                                    </h3>
                                </div>
                                {{-- FIN-CATEGORIAS --}}


                            @endforeach
                        </div>

                        @if($categoriaSeleccionada)
                            <div class="rounded-4xl shadow-lg p-6 md:p-8">
                                @if($productosFiltrados->isNotEmpty())
                                    <div class="grid grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6 gap-6">
                                        @foreach($productosFiltrados as $producto)
                                            {{-- PRODUCTOS --}}
                                            <div
                                                class="p-6 border border-gray-600 bg-gray-900 rounded-2xl transition transform hover:scale-110 shadow-2xl hover:bg-green-800   cursor-pointer flex flex-col justify-between h-full"
                                                wire:click="agregarProducto({{ $producto->id }})">

                                                <div class="mb-3">
                                                    <h4 class="font-semibold text-white text-lg md:text-xl truncate">{{ $producto->nombre }}</h4>
                                                    <p class="text-gray-300 text-sm mt-1">
                                                        ${{ number_format($producto->precio_venta, 2) }}</p>
                                                </div>

                                                <div
                                                    class="flex justify-between items-center mt-auto text-xxs md:text-sm">
                                                <span
                                                    class="{{ $producto->unidades > 0 ? 'text-green-500 font-medium' : 'text-red-500 font-medium' }}">
                                                    {{ $producto->unidades }} unidades
                                                </span>
                                                </div>
                                            </div>
                                            {{-- FIN-PRODUCTOS --}}

                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-400 text-center py-6">No hay productos disponibles en esta
                                        categoría.</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- TICKET --}}
                    <div class="w-full md:w-1/4">
                        @if($ticket)
                            @livewire('ticket-mesas-component', ['ticketId' => $ticket->id], key('ticket-'.$ticket->id))
                        @endif
                    </div>

                </div>
            </div>
        @else

            {{-- COMANDAS REGISTRADAS --}}
            <div class="bg-gray-600 shadow-2xl rounded-4xl p-6 md:p-8">
                <h3 class="text-2xl font-semibold m-auto mb-6 sticky top-0 bg-gray-50 shadow w-full rounded-3xl p-5 text-center">
                    Comandas registradas
                </h3>

                <div
                    class="hidden md:flex font-semibold text-gray-400 border-b to-pink-50 border-gray-700 pb-3 mb-3 text-2xl m-auto mb-4 sticky top-19 bg-gray-50 shadow w-full rounded-3xl p-5 text-center">
                    <div class="w-3/12">Producto</div>
                    <div class="w-2/12">Cantidad</div>
                    <div class="w-3/12">Notas</div>
                    <div class="w-2/12">Usuario</div>
                    <div class="w-1/12">Hora</div>
                    <div class="w-1/12">Acciones</div>
                </div>
                <div class="grid gap-2 h-max-90">
                    @forelse($comandas as $comanda)
                        @livewire('edit-comanda-component', ['comanda' => $comanda], key($comanda->id))
                    @empty
                        <p class="text-gray-400 py-6 text-center">No hay comandas aún para esta mesa.</p>
                    @endforelse
                </div>
            </div>

        @endif


    </div>
</div>
