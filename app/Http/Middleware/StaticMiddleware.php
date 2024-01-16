<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Symfony\Component\HttpFoundation\Response;

class StaticMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if(!$request->header("MEZER-KEY") || $request->header("MEZER-KEY") != MEZER_KEY){
                return response()->json(ResponseFormatter::failed(401, __("Unauthorized"), UNAUTHORIZED), 401);
            }
        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed(401, __("Unauthorized")), 401);
        }

        return $next($request);
    }
}
