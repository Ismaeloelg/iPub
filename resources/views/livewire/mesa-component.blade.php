<div>
    <div class="text-3xl font-bold  text-center sticky top-0 ">Sala</div>
    <div class="grid grid-cols-5 gap-6 justify-center overflow-y-auto max-h-155 p-1 rounded-4xl">
        @foreach($mesas as $mesa)
            <div wire:click="abrirMesa({{ $mesa->id }})"
                 class="cursor-pointer p-5 rounded-4xl shadow-lg transition-transform transform hover:scale-105
                        {{ $mesa->comandas->isNotEmpty() ? 'bg-red-400 text-white' : 'bg-green-600 text-white' }}
                        flex flex-col justify-between items-center">

                <!-- Número de mesa -->
                <h2 class="text-xl font-bold mb-2">Mesa #{{ $mesa->id }}</h2>

                <!-- Estado visual -->
                <span class="text-sm mb-2 px-3 py-1 rounded-full font-semibold
                             {{ $mesa->comandas->isNotEmpty() ? 'bg-red-600' : 'bg-green-700' }}">
                    {{ $mesa->comandas->isNotEmpty() ? 'Ocupada' : 'Libre' }}
                </span>

                <!-- Productos y total -->
                <p class="text-sm mb-1">Productos: <strong>{{ $mesa->comandas->count() }}</strong></p>
                <p class="text-sm mb-1">Total: <strong>${{ number_format($mesa->total ?? 0, 2) }}</strong></p>

                <!-- Forma de pago opcional -->
                @if($mesa->forma_pago)
                    <p class="text-sm opacity-90">Pago: <strong>{{ ucfirst($mesa->forma_pago) }}</strong></p>
                @endif

            </div>
        @endforeach
    </div>
</div>
