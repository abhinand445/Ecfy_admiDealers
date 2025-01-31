<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        
        if (!auth()->check() || auth()->user()->role !== $role) {
           
            return response()->json([
                'message' => 'Access Denied. You do not have the required permissions.'
            ], 403);
        }

        
        return $next($request);
    }
}
