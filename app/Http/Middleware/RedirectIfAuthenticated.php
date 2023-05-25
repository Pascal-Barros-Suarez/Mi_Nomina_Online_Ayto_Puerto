<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                $admin = Auth::user();

                if($admin == null){
                    return redirect()->route('dashboard'); // Redirige a la ruta 'dashboard' si el usuario es administrador
                } else if ( $admin->isAdmin()) {
                    return redirect()->route('backpack.dashboard'); // Redirige a la página de inicio por defecto si el usuario no es administrador
                } else {
                     return redirect()->route('dashboard'); // Redirige a la página de inicio por defecto si el usuario no es administrador
                }

                // El código que está después del return no se ejecutará
                // Si llegas a este punto, asegúrate de que los redireccionamientos anteriores funcionen correctamente
            }
            
            
        }

        return $next($request);
    }
}
