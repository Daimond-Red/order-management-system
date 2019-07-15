<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Permit;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'admin.vehicles.form'

        ], function ($view) {
            $permits = Permit::pluck('title', 'id')->toArray();
            
            $view->with('permits', $permits);
        });

        
    }
}
