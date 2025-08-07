<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Laravel\passport\passport;
class AppServiceProvider extends ServiceProvider
{

    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->group(base_path('routes/api.php'));
    }


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
        $this->mapApiRoutes();
        // $this-> registerPolicies();
        // if(!$this -> app->routesAreCached()){
        //     Passport::routes();
        // }
        // Add any other route mapping methods here, like mapWebRoutes()
    }
}