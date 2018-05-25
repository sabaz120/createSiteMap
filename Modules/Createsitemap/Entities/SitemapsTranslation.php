<?php

namespace Modules\Createsitemap\Entities;

use Illuminate\Database\Eloquent\Model;

class SitemapsTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'createsitemap__sitemaps_translations';
}
