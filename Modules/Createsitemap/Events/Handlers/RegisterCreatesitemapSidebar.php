<?php

namespace Modules\Createsitemap\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterCreatesitemapSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item('Create SiteMap', function (Item $item) {
                $item->icon('fa fa-sitemap');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                // $item->item(trans('createsitemap::sitemaps.title.sitemaps'), function (Item $item) {
                //     $item->icon('fa fa-copy');
                //     $item->weight(0);
                //     $item->append('admin.createsitemap.sitemaps.create');
                //     $item->route('admin.createsitemap.sitemaps.index');
                //     $item->authorize(
                //         $this->auth->hasAccess('createsitemap.sitemaps.index')
                //     );
                // });
                $item->item('Generate SiteMap.xml', function (Item $item) {
                    $item->icon('fa fa-sitemap');
                    $item->weight(0);
                    $item->append('admin.createsitemap.sitemaps.create');
                    $item->route('admin.createsitemap.sitemaps.generatesitemap');
                });
// append

            });
        });

        return $menu;
    }
}
