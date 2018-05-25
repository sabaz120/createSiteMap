<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/createsitemap'], function (Router $router) {
    $router->bind('sitemaps', function ($id) {
        return app('Modules\Createsitemap\Repositories\SitemapsRepository')->find($id);
    });
    $router->get('sitemaps', [
        'as' => 'admin.createsitemap.sitemaps.index',
        'uses' => 'SitemapsController@index',
        'middleware' => 'can:createsitemap.sitemaps.index'
    ]);
    $router->get('generatexml', [
        'as' => 'admin.createsitemap.sitemaps.generatesitemap',
        'uses' => 'SitemapsController@generateSiteMap'
    ]);
    $router->get('sitemaps/create', [
        'as' => 'admin.createsitemap.sitemaps.create',
        'uses' => 'SitemapsController@create',
        'middleware' => 'can:createsitemap.sitemaps.create'
    ]);
    $router->post('sitemaps', [
        'as' => 'admin.createsitemap.sitemaps.store',
        'uses' => 'SitemapsController@store',
        'middleware' => 'can:createsitemap.sitemaps.create'
    ]);
    $router->get('sitemaps/{sitemaps}/edit', [
        'as' => 'admin.createsitemap.sitemaps.edit',
        'uses' => 'SitemapsController@edit',
        'middleware' => 'can:createsitemap.sitemaps.edit'
    ]);
    $router->put('sitemaps/{sitemaps}', [
        'as' => 'admin.createsitemap.sitemaps.update',
        'uses' => 'SitemapsController@update',
        'middleware' => 'can:createsitemap.sitemaps.edit'
    ]);
    $router->delete('sitemaps/{sitemaps}', [
        'as' => 'admin.createsitemap.sitemaps.destroy',
        'uses' => 'SitemapsController@destroy',
        'middleware' => 'can:createsitemap.sitemaps.destroy'
    ]);
// append

});
