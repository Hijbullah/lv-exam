<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share('batch', function(Request $request) {
            if (! $request->user()) {
                return;
            };

            $batch = $request->user()->batches->first();
            if(! $batch) {
               return; 
            };

            return [
                'is_approved' => $batch->pivot->is_active,
                'batch' => $batch->only('id', 'batch_id', 'name')
            ];

        });
    }
}
