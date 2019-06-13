<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // si esta logueado lo envia al inicio correspondiente
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->hasRole('administrador') || Auth::user()->hasRole('super_usuario')) {
                return redirect()->route('in.inicio');
            }else if(Auth::user()->hasRole('vendedor')) {
                return redirect()->route('in.venta.index');
            }else if(Auth::user()->hasRole('repositor')){
                return redirect()->route('in.inventario.index');
            }
        }

        return $next($request);
    }
}
