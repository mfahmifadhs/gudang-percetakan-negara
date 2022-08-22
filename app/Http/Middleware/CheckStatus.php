<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $status)
    {
        if ($status == 'aktif' && auth()->user()->status_id != 1) 
        {
            abort(403);
        }

        if ($status == 'tidak-aktif' && auth()->user()->status_id != 2) 
        {
            abort(403);
        }


        return $next($request);
    }
}
