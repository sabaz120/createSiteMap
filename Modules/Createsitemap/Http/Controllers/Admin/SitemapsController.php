<?php

namespace Modules\Createsitemap\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Createsitemap\Entities\Sitemaps;
use Modules\Createsitemap\Http\Requests\CreateSitemapsRequest;
use Modules\Createsitemap\Http\Requests\UpdateSitemapsRequest;
use Modules\Createsitemap\Repositories\SitemapsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SitemapsController extends AdminBaseController
{
    /**
     * @var SitemapsRepository
     */
    private $sitemaps;

    public function __construct(SitemapsRepository $sitemaps)
    {
        parent::__construct();

        $this->sitemaps = $sitemaps;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

     public function callFunction(){
       echo 'hola';
     }
     public function GenerateSiteMapRoutes(){
       /*
       Array Structure: path of entity,route that receives parameter,
       */
       $routes=$this->callFunction();
     }

    public function generateSiteMap(){
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
      $app = app();
      $routes = $app->routes->getRoutes();
      $xml .=
      '<url>
      <loc>http://'.$_SERVER["HTTP_HOST"].'/</loc>
      <lastmod>'.date("Y-m-d H:i:s").'</lastmod>
      <priority>0.80</priority>
      </url>';
      foreach($routes as $route){
        // echo 'Uri: '.$route->uri.' Name: '.$route->getName().' Prefix: '.$route->getPrefix().' Method: '.$route->getActionMethod().'<br>';
        if($route->getActionMethod()=="show"){
          if(strpos($route->uri, 'backend') !== false || strpos($route->uri, '{') !== false){

          }else{
            echo 'Routes: '.$route->uri.'<br>';
            $xml .=
            '<url>
            <loc>http://'.$_SERVER["HTTP_HOST"].'/'.$route->uri.'</loc>
            <lastmod>'.date("Y-m-d H:i:s").'</lastmod>
            <priority>0.80</priority>
            </url>';
          }
        }
      }
      $xml .='</urlset>';
      $file_name = "sitemap.xml";

      if(file_exists($file_name))
      {
        $mensaje = "The file $file_name it has been modified";
      }
      else
      {
        $mensaje = "The file $file_name it has been created";
      }

      if($archivo = fopen($file_name, "w"))
      {
        if(fwrite($archivo, $xml))
        {
          echo "It has been executed correctly";
        }
        else
        {
          echo "There was a problem creating the file.";
        }

        fclose($archivo);
      }
      // var_dump($xml);
      ////////Fin
      // dd('stop');
    }
    public function index()
    {
        //$sitemaps = $this->sitemaps->all();

        return view('createsitemap::admin.sitemaps.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('createsitemap::admin.sitemaps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSitemapsRequest $request
     * @return Response
     */
    public function store(CreateSitemapsRequest $request)
    {
        $this->sitemaps->create($request->all());

        return redirect()->route('admin.createsitemap.sitemaps.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('createsitemap::sitemaps.title.sitemaps')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Sitemaps $sitemaps
     * @return Response
     */
    public function edit(Sitemaps $sitemaps)
    {
        return view('createsitemap::admin.sitemaps.edit', compact('sitemaps'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Sitemaps $sitemaps
     * @param  UpdateSitemapsRequest $request
     * @return Response
     */
    public function update(Sitemaps $sitemaps, UpdateSitemapsRequest $request)
    {
        $this->sitemaps->update($sitemaps, $request->all());

        return redirect()->route('admin.createsitemap.sitemaps.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('createsitemap::sitemaps.title.sitemaps')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Sitemaps $sitemaps
     * @return Response
     */
    public function destroy(Sitemaps $sitemaps)
    {
        $this->sitemaps->destroy($sitemaps);

        return redirect()->route('admin.createsitemap.sitemaps.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('createsitemap::sitemaps.title.sitemaps')]));
    }
}
