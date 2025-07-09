<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define la ruta base de la API y web.
     */
    public function boot()
    {
        $this->routes(function () {
            // Cargar rutas de la API
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
              

            // Cargar rutas web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
