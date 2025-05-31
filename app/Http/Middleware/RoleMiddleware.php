<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
{
    if (!Auth::check()) {
        return redirect()->route('login'); // pastikan user login dulu
    }

    $roles = explode('|', $role);

    if (in_array(Auth::user()->role, $roles)) {
        return $next($request);
    }

    abort(403, 'Akses ditolak.');
}

}
