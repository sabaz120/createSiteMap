<?php

namespace Modules\Createsitemap\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Sitemaps extends Model
{
    use Translatable;

    protected $table = 'createsitemap__sitemaps';
    public $translatedAttributes = [];
    protected $fillable = [];
}
