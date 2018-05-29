# createSiteMap
Module to create site map of asgardCMS routes

Useful Module when you need to create the sitemap of your site. This was developed and used in the Asgard CMS environment in its version 3.5.3.

Features:
- Obtain all project routes whose method is show, index and homepage type.
- Generates 2 files: sitemap.xml and sitemap.html, where the last file is a nice view for the user in which you can see the list of routes that were generated in the sitemap.xml.

## Install

1) In your terminal:

  $ composer require sabaz120/createSiteMap

  With this, the module will be downloaded into your project.

  $ composer require diversen/get-meta-tags

  This will install a package to get the names of each page

2) Add the following to your composer.json:

In the autoload section in psr-4 add the following line:

"diversen": "vendor/diversen/get-meta-tags/"

Something similar to this:

    "autoload": {
        "classmap": [
            "database"
        ],
        "psr-4": {
            "App\\": "app/",
            "Modules\\": "Modules/",
            "diversen": "vendor/diversen/get-meta-tags/"
        }
    }
    
3) After adding the module, it is necessary to grant it permissions so that it can be viewed in the administrative panel (backend route)

## Usage:

1) Enter the administrative panel (backend route) and enter the Createsitemap module
2) Automatically when entering both files are generated (sitemap.xml and sitemap.html) in the public folder of your project.

Note: This module will take all the active frontend routes of the project whose method is of type show and load them in the sitemap.xml. That is, routes like http://example.com/en/contact/ or http://example.com/en/support-in-line will be loaded in the sitemap.xml
Although if you are managing content like a blog, you will have routes like /en/{$ category-> slug}/, these routes are not taken into account for the construction of the sitemap.xml, therefore, it is necessary to build them with the parameters corresponding to be taken into account at the time of construction of the sitemap.xml.
Here is an example:
                   
                      foreach (Category::all()  as $category) {
                          $router->group(['prefix' => $category->slug], function (Router $router) use ($category) {
                          $locale = LaravelLocalization::setLocale() ?: App::getLocale();
                          $router->get('/', [
                          'as' => $locale . '.iblog.' . $category->slug,
                          'uses' => 'PublicController@index',
                          ]);
                          });
                      }//foreach
                      
With this foreach which is marked in green, several routes are being created depending on the number of categories that exist in the database, that is, if there are 3 categories (clothes, computing, phones) 3 routes will be created:
1) http://example.com/en/clothes/

2) http://example.com/en/computing/

3) http://example.com/en/phones/

After finishing generating the sitemap.xml, I would recommend commenting the foreach lines, since they are no longer necessary in the project and could cause problems with similar routes
    













