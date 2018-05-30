<?php

namespace Modules\Createsitemap\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Createsitemap\Entities\Sitemaps;
use Modules\Createsitemap\Http\Requests\CreateSitemapsRequest;
use Modules\Createsitemap\Http\Requests\UpdateSitemapsRequest;
use Modules\Createsitemap\Repositories\SitemapsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use diversen\meta;
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

    public function generateSiteMap(){
      $html='<!DOCTYPE html>
      <html lang="en" dir="ltr">
        <head>
          <meta charset="utf-8">
          <title>'.$_SERVER["HTTP_HOST"].'</title>
          <style type="text/css">
      	body {
      		background-color: #fff;
      		font-family: "Roboto", "Helvetica", "Arial", sans-serif;
      		margin: 0;
      	}

      	#top {

      		background-color: #b1d1e8;
      		font-size: 16px;
      		padding-bottom: 40px;
      	}

      	h3 {
      		margin: auto;
      		padding: 10px;
      		max-width: 600px;
      		color: #666;
      	}

      	h3 span {
      		float: right;
      	}

      	h3 a {
      		font-weight: normal;
      		display: block;
      	}


      	#cont {
      		position: relative;
      		border-radius: 6px;
      		box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);

      		background: #f3f3f3;

      		margin: -20px 30px 0px 30px;
      		padding: 20px;
      	}

      	a:link,
      	a:visited {
      		color: #0180AF;
      		text-decoration: underline;
      	}

      	a:hover {
      		color: #666;
      	}

      	#footer {
      		padding: 10px;
      		text-align: center;
      	}

      	ul {
          	margin: 0px;

          	padding: 0px;
          	list-style: none;
      	}
      	li {
      		margin: 0px;
      	}
      	li ul {
      		margin-left: 20px;
      	}

      	.lpage {
      		border-bottom: #ddd 1px solid;
      		padding: 5px;
      	}
      	.last-page {
      		border: none;
      	}
      	</style>
        </head>
        <body>
          <div id="top" style="text-align:center;">
            <h3>Generated Site Map - '.$_SERVER["HTTP_HOST"].'</h3>
          </div>
          <div id="cont">
            <label> Sites of project</label>
            <ul>';
      $m=new meta();
      // $ary=$m->getMeta("http://www.imaginacolombia.com/");
      // print_r($ary);
      // // print_r($ary['title']);
      // dd('stop');
      $routesArray=array();
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
      $app = app();
      $routes = $app->routes->getRoutes();
      $xml.="";
      foreach($routes as $route){
        // echo 'Uri: '.$route->uri.' Name: '.$route->getName().' Prefix: '.$route->getPrefix().' Method: '.$route->getActionMethod().'<br>';
        if($route->getActionMethod()=="show" || $route->getActionMethod()=="index" || $route->getActionMethod()=="homepage"){
          if(strpos($route->uri, 'backend') !== false || strpos($route->uri, '{') !== false || strpos($route->uri, 'api') !== false){

          }else{
            // echo 'Routes: '.$route->uri.'<br>';
            $xml .=
            '<url>
            <loc>http://'.$_SERVER["HTTP_HOST"].'/'.$route->uri.'</loc>
            <lastmod>'.date("Y-m-d H:i:s").'</lastmod>
            <priority>1.00</priority>
            </url>';
            $ary=$m->getMeta("http://".$_SERVER["HTTP_HOST"]."/".$route->uri);
            $routesArray=array_merge($routesArray,array(['tittle'=>$ary['title'],'route'=>"http://".$_SERVER["HTTP_HOST"]."/".$route->uri]));
            // print_r($ary['title']);
          }//else
        }//Type method route = show
      }//foreach routes
      foreach($routesArray as $ar){
        if(is_null($ar['tittle']))
          $html.='<li class="lpage"><a href="'.$ar['route'].'/">'.$ar['route'].'</a></li>';
        else
          $html.='<li class="lpage"><a href="'.$ar['route'].'/">'.$ar['tittle'].'</a></li>';
      }
      $html.='</ul></div>
      <div id="footer">
      <a href="http://'.$_SERVER["HTTP_HOST"].'/">'.$_SERVER["HTTP_HOST"].'</a> - Site Map - Last Updated '.date("Y-m-d H:i:s").'
      </div>
      </body>
      </html>
      ';
      $file_name_html = "sitemap.html";
      file_exists($file_name_html);
      // dd('stop');
      if($file = fopen($file_name_html, "w")){
        if(fwrite($file, $html)){
          $message="It has been executed correctly";
        }
        fclose($file);
      }//if($file = fopen($file_name, "w")){
      $xml .='</urlset>';
      $file_name = "sitemap.xml";
      if(file_exists($file_name))
        $message = "The file $file_name it has been modified";
      else
        $message = "The file $file_name it has been created";
      if($file = fopen($file_name, "w")){
        if(fwrite($file, $xml)){
          $message="It has been executed correctly";
          $b=1;
        }
        else
          $message="There was a problem creating the file.";
        fclose($file);
      }//if($file = fopen($file_name, "w")){
      if($b==1)
        return view('createsitemap::admin.sitemaps.viewSiteMapXML',array('success'=>1,'xml'=>$xml,'message'=>$message,'routes'=>$routesArray));
      else
        return view('createsitemap::admin.sitemaps.viewSiteMapXML',array('success'=>0,'message'=>$message));
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
