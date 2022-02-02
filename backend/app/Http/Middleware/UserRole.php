<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            // 
            $response = [
                'success' => false,
                'message' => "UnAuthorized",
            ];
            return response()->json($response, 401);
        }
        if (!$request->user()->hasRole($role)) {
            // Redirect...
            $response = [
                'success' => false,
                'message' => "Forbidden",
            ];

            return response()->json($response, 403);
        }

        return $next($request);
    }

}