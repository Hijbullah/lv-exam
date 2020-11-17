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
        if (!$request->user()->batch_id || !$request->user()->is_batch_approved) {
            return redirect()->route('app.batches.show');
        }

        return $next($request);
    }
}
