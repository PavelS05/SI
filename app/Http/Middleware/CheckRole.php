<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check())
            return redirect('login');

        if(in_array(auth()->user()->role, $roles))
            return $next($request);
            
        return redirect('/')->with('error', 'Unauthorized access');
    }
}
