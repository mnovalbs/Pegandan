<?php

namespace App\Http\Middleware;

use Closure;

class occupation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $occupation)
    {
        if($request->user()->occupation == $occupation){
            return $next($request);
        }
        
        return redirect('/');
    }
}
