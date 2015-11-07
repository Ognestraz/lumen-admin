<?php

namespace Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if the class aliases have been registered.
     *
     * @var bool
     */
    protected static $aliasesRegistered = false;
    
    public function boot()
    {
        if (!static::$aliasesRegistered) {
            static::$aliasesRegistered = true;
            class_alias('Collective\Html\HtmlFacade', 'Html');
            class_alias('Collective\Html\FormFacade', 'Form');
            class_alias('Illuminate\Support\Facades\Input', 'Input');
            class_alias('Intervention\Image\Facades\Image', 'Img');
        }

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin');

        require_once __DIR__.'/../Support/helpers.php';

        $app = app();
        $app->routeMiddleware([
           'auth.admin' => 'Admin\Http\Middleware\AuthenticateAdmin'
        ]);

        $app->register('Collective\Html\HtmlServiceProvider');
        $app->register('Intervention\Image\ImageServiceProvider');

        $app->register(MacroServiceProvider::class);

        $app->group(['namespace' => 'Admin\Http\Controllers'], function ($app) {
            require __DIR__.'/../Http/routes.php';
        });

        $this->publishes([
            __DIR__.'/../../public/build' => base_path('public/build'),
            __DIR__.'/../../public/css' => base_path('public/css'),
            __DIR__.'/../../public/js' => base_path('public/js'),
            __DIR__.'/../../database/migrations' => base_path('database/migrations'),
            __DIR__.'/../../database/seeds' => base_path('database/seeds')
        ]);
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
