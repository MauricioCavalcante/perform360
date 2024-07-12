<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCoordinator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->grupo_id === 2) {
            return $next($request);
        }

        // Redirecionar ou retornar erro caso o usuário não seja um Coordenador
        return redirect('/')->with('error1', 'Acesso não autorizado.');
    }
}
