<?php

namespace Modules\Createsitemap\Repositories\Cache;

use Modules\Createsitemap\Repositories\SitemapsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSitemapsDecorator extends BaseCacheDecorator implements SitemapsRepository
{
    public function __construct(SitemapsRepository $sitemaps)
    {
        parent::__construct();
        $this->entityName = 'createsitemap.sitemaps';
        $this->repository = $sitemaps;
    }
}
