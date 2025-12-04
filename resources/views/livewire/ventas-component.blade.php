<div class="min-h-screen bg-gray-900 flex flex-col items-center justify-start py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-8">

        <!-- Título -->
        <h2 class="text-3xl font-extrabold text-white text-center">Resumen de Ventas</h2>

        <!-- Resumen de ventas -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="p-6 bg-green-700 rounded-2xl shadow-lg text-white text-center">
                <h3 class="font-semibold text-lg mb-2">Ventas del Día</h3>
                <p class="text-2xl font-bold">${{ number_format($ventasHoy, 2) }}</p>
            </div>
            <div class="p-6 bg-blue-700 rounded-2xl shadow-lg text-white text-center">
                <h3 class="font-semibold text-lg mb-2">Ventas del Mes</h3>
                <p class="text-2xl font-bold">${{ number_format($ventasMes, 2) }}</p>
            </div>
            <div class="p-6 bg-yellow-600 rounded-2xl shadow-lg text-white text-center">
                <h3 class="font-semibold text-lg mb-2">Ventas del Año</h3>
                <p class="text-2xl font-bold">${{ number_format($ventasAnuales, 2) }}</p>
            </div>
        </div>

        <!-- Tickets de hoy -->
        <div class="bg-gray-800 rounded-2xl shadow-xl p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Tickets de Hoy</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse text-gray-200">
                    <thead>
                    <tr class="bg-gray-700">
                        <th class="border px-4 py-2 text-left">Ticket #</th>
                        <th class="border px-4 py-2 text-left">Total</th>
                        <th class="border px-4 py-2 text-left">Cerrado En</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ticketsHoy as $ticket)
                        <tr class="hover:bg-gray-700 transition-colors">
                            <td class="border px-4 py-2">{{ $ticket->numero_ticket }}</td>
                            <td class="border px-4 py-2">${{ number_format($ticket->total, 2) }}</td>
                            <td class="border px-4 py-2">{{ $ticket->cerrado_en }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
