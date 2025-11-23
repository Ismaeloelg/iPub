<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, string $role): Response
    {
        $userId = session('logged_user_id');
        $user = $userId ? User::find($userId) : null;

        if (!$user || !$user->hasRole($role)) {
            return redirect()->route('welcome')
                ->with('error', 'No tienes permisos para acceder a esta página.');
        }
        return $next($request);
    }
}
