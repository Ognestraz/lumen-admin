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
        
        $this->loadViewsFrom(app()->resourcePath('views'), 'admin');
        
        require_once app()->basePath('app/Support/helpers.php');
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
