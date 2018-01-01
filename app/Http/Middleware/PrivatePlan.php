<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PrivatePlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->subscribedToPlan(['private'])) {
            return redirect('home')->with(['message' => "You are not subscribed to the private plan. <a href='/settings#/subscription'>Consider upgrading</a> to get unlimited public and private repositories"]);
        }

        return $next($request);
    }
}
