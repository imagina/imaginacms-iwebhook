<?php

namespace Modules\Iwebhooks\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Iwebhooks\Listeners\RegisterIwebhooksSidebar;

class IwebhooksServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIwebhooksSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });


    }

    public function boot()
    {
       
        $this->publishConfig('iwebhooks', 'config');
        $this->publishConfig('iwebhooks', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('iwebhooks', 'settings'), "asgard.iwebhooks.settings");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iwebhooks', 'settings-fields'), "asgard.iwebhooks.settings-fields");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iwebhooks', 'permissions'), "asgard.iwebhooks.permissions");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iwebhooks', 'blocks'), "asgard.iwebhooks.blocks");

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Iwebhooks\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Iwebhooks\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Iwebhooks\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iwebhooks\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iwebhooks\Repositories\HookRepository',
            function () {
                $repository = new \Modules\Iwebhooks\Repositories\Eloquent\EloquentHookRepository(new \Modules\Iwebhooks\Entities\Hook());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iwebhooks\Repositories\Cache\CacheHookDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iwebhooks\Repositories\LogRepository',
            function () {
                $repository = new \Modules\Iwebhooks\Repositories\Eloquent\EloquentLogRepository(new \Modules\Iwebhooks\Entities\Log());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iwebhooks\Repositories\Cache\CacheLogDecorator($repository);
            }
        );
// add bindings



    }

    /**
     * Register Blade components
     */

    private function registerComponents(){
        Blade::componentNamespace("Modules\Iwebhooks\View\Components", 'iwebhooks');
    }
}
