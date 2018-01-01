<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AnyPlan
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
        if (!Auth::user()->subscribedToPlan(['private', 'organization'])) {
            return redirect('home')->with(['message' => "You are not subscribed to any plans. <a href='/settings#/subscription'>Consider upgrading</a> to get unlimited public and private repositories"]);
        }

        return $next($request);
    }
}
