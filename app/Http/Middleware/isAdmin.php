<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth as auth;
use Closure;

class isAdmin
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
        if (auth::check()&& $request->session()->get('isAdmin')){
            return $next($request);
    
        }
        else {return redirect()->route('login');
        
        }
    }
}
