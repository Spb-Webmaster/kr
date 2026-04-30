<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsVendorMiddleware
{
    public function handle(Request $request, Closure $next): Response|string
    {

        if(route_name() == 'vendor_login') {

            if(session()->get('v')) {
                return redirect(route('cabinet_vendor'));
            }
            return $next($request);


        }

        if(session()->get('v')) {

            return $next($request);
        }


        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return redirect(route('vendor_login'));



    }
}
