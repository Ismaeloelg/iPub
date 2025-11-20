<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next,): Response
    {
        $userId = session('logged_user_id');
        $user = $userId ? User::find($userId) : null;

        if (!$user) {
            return redirect()->route('welcome')
                ->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }
        return $next($request);
    }
}
