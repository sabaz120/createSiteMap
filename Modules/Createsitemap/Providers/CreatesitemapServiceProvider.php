<?php

namespace Modules\Createsitemap\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Createsitemap\Events\Handlers\RegisterCreatesitemapSidebar;

class CreatesitemapServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterCreatesitemapSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('sitemaps', array_dot(trans('createsitemap::sitemaps')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('createsitemap', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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
            'Modules\Createsitemap\Repositories\SitemapsRepository',
            function () {
                $repository = new \Modules\Createsitemap\Repositories\Eloquent\EloquentSitemapsRepository(new \Modules\Createsitemap\Entities\Sitemaps());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Createsitemap\Repositories\Cache\CacheSitemapsDecorator($repository);
            }
        );
// add bindings

    }
}
