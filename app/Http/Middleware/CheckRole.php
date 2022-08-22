<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($role == 'admin-master' && auth()->user()->role_id != 1) {
            abort(403);
        }

        if ($role == 'admin-user' && auth()->user()->role_id != 2) {
            abort(403);
        }

        if ($role == 'unit-kerja' && auth()->user()->role_id != 3) {
            abort(403);
        }
        if ($role == 'petugas' && auth()->user()->role_id != 4) {
            abort(403);
        }

        return $next($request);
    }
}
