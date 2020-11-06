<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBatch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->batches()->exists() || !$request->user()->batches()->first()->pivot->is_active) {
            return redirect()->route('app.batches.show');
        }

        return $next($request);
    }
}
