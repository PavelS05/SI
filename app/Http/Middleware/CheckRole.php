<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $allowedRoles = explode(',', $roles);
        
        if (!in_array(auth()->user()->role, $allowedRoles)) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}