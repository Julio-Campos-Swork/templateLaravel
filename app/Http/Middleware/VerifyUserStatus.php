<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class VerifyUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user != null && $user->status === 0) {
            // $request->user()->tokens()->delete();
            return response()->json(['status' => false, 'message' => 'Tu usuario se encuentra desactivado contacta al administrador'], 200);
        }
        return $next($request);
    }
}
