<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('customer')->check()) {
            $user = Auth::guard('customer')->id();
            Customer::where('customerID', $user)->update(['last_seen' => Carbon::now()]);
        }
        return $next($request);
    }
}
