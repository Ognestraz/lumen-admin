<?php namespace Admin\Providers;

use Collective\Html\HtmlServiceProvider;
use Collective\Html\FormBuilder;
use Form;

class MacroServiceProvider extends HtmlServiceProvider 
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        FormBuilder::macro('template', function ($template, $empty = false, $field = 'template') {

            $template_list = '';
            if ($empty) {

                $template_list[''] = '-';

            }

            $folder = base_path() . '/resources/views/site/site/';

            if (is_dir($folder)) {

                $iterator = new \DirectoryIterator($folder);

                foreach ($iterator as $fileinfo) {

                    if ($fileinfo->isFile() && !$fileinfo->isDot()) {

                        $file = explode('.', $fileinfo->getFilename());
                        array_pop($file);

                        $value = implode('.', $file);
                        $template_list[$value] = $value;

                    }

                }    

            }

            if ($template_list) {
                return Form::select($field, $template_list, $template, ['class' => "form-control"]);
            }

            return '';

        });

    }
}
