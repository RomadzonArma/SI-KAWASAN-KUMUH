<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    // protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/check-access';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        Route::middleware(['web', 'auth'])->group(function () {
            $this->mapDashboardRoutes();

            $this->mapUserRoutes();

            $this->mapMenuRoutes();

            $this->mapOtoritasRoutes();

            $this->mapDataAsetRoutes();

            $this->mapPertanahanRoutes();
            
            $this->mapJalanLingkunganRoutes();
            $this->mapCustomFrontRoutes();
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            // ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            // ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapDashboardRoutes()
    {
        Route::prefix('dashboard')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/dashboard.php'));
    }

    protected function mapUserRoutes()
    {
        Route::prefix('users')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/users.php'));
    }

    protected function mapMenuRoutes()
    {
        Route::prefix('manajemen-menu')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/menu.php'));
    }

    protected function mapOtoritasRoutes()
    {
        Route::prefix('otoritas')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/otoritas.php'));
    }

    protected function mapDataAsetRoutes()
    {
        Route::prefix('data-aset')
            ->group(base_path('routes/panel/data-aset.php'));
    }

    protected function mapPertanahanRoutes()
    {
        Route::prefix('pertanahan')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/pertanahan.php'));
    }

    protected function mapJalanLingkunganRoutes()
    {
        Route::prefix('jalan-lingkungan')
            ->group(base_path('routes/panel/jalan-lingkungan.php'));
    }
    protected function mapCustomFrontRoutes()
    {
        Route::prefix('custom-front')
            ->group(base_path('routes/panel/custom-front.php'));
    }
}
