<?php

namespace App\Http\Middleware;

use App\Models\Cliente;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ConectarCliente
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener el subdominio del cliente (ejemplo: cliente1.tuapp.com)
        $subdominio = explode('.', $request->getHost())[0];

        // Buscar cliente en la base de datos global
        $cliente = Cliente::where('subdominio', $subdominio)->first();

        if (!$cliente) {
            abort(404, 'Cliente no encontrado');
        }

        // Cambiar la conexión 'tenant' dinámicamente
        Config::set('database.connections.tenant.database', $cliente->db_name);
        DB::purge('tenant');      // Limpiar conexión anterior
        DB::reconnect('tenant');  // Reconectar a la base de datos del cliente
        return $next($request);
    }
}
