<?php

namespace TypiCMS\Modules\Objects\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Objects\Composers\SidebarViewComposer;
use TypiCMS\Modules\Objects\Facades\Objects;
use TypiCMS\Modules\Objects\Models\Object;
use TypiCMS\Modules\Objects\Repositories\EloquentObject;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.objects'
        );
        $this->mergeConfigFrom(
            __DIR__.'/../config/permissions.php', 'typicms.permissions'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['objects' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'objects');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'objects');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/objects'),
        ], 'views');

        AliasLoader::getInstance()->alias('Objects', Objects::class);

        // Observers
        Object::observe(new SlugObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $app->view->composer('objects::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('objects');
        });

        $app->bind('Objects', EloquentObject::class);
    }
}
