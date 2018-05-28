@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('createsitemap::sitemaps.title.sitemaps') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('createsitemap::sitemaps.title.create sitemaps') }}</li>
    </ol>
@stop
@push('css-stack')
  <style media="screen">
    .margin20px{
      text-indent:20px;
    }
    .margin40px{
      text-indent:40px;
    }
  </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header text-center">
                    <h2><span class="text-primary">Instructions</span> </h2>
                      <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Read</button>
                </div>
                <hr>
                <!-- /.box-header -->
                <div class="box-body">
                  @if($success==1)
                  <div class="text-center">
                    <h2><span class="text-success">Sitemap.xml {{$message}} </span> </h2>
                  </div>
                  <label>Content of sitemap.xml:</label>
                  <textarea name="name" class="form-control" rows="20" readonly="true" cols="80">{{$xml}}</textarea>
                  @else
                  <div class="text-center jumbotron">
                    <h2><span class="text-danger">{{$message}}.</span></h2>
                  </div>
                  @endif
                </div>
                <!-- /.box -->
            </div>
            <div class="col-lg-12">
              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header text-primary">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title text-center">Manual of Instruction</h4>
                    </div>
                    <div class="modal-body">
                      <p class="margin20px">This module will take all the active frontend routes of the project whose method is of type show and load them in the sitemap.xml. That is, routes like http://example.com/en/contact/ or http://example.com/en/support-in-line will be loaded in the sitemap.xml</p>
                      <p class="margin20px">Although if you are managing content like a blog, you will have routes like /en/{$ category-> slug}/, these routes are not taken into account for the construction of the sitemap.xml, therefore, it is necessary to build them with the parameters corresponding to be taken into account at the time of construction of the sitemap.xml.</p>
                      <p>Here is an example:</p>
                      <div style="container" style="text-align: justify;">
                        <span style="color:green">foreach (Category::all()  as $category) {</span>
                          <p class="margin20px">$router->group(['prefix' => $category->slug], function (Router $router) use ($category) {</p>
                          <p class="margin40px">$locale = LaravelLocalization::setLocale() ?: App::getLocale();</p>
                          <p class="margin40px">$router->get('/', [</p>
                          <p class="margin40px">'as' => $locale . '.iblog.' . $category->slug,</p>
                          <p class="margin40px">'uses' => 'PublicController@index',</p>
                          <p class="margin40px">]);</p>
                          <p class="margin20px">});</p>
                          <p><span style="color:green">}//foreach</span></p>
                      </div>
                      <p class="margin20px">With this foreach which is marked in green, several routes are being created depending on the number of categories that exist in the database, that is, if there are 3 categories (clothes, computing, phones) 3 routes will be created:</p>
                      <p>1.http://example.com/en/clothes/</p>
                      <p>2.http://example.com/en/computing/</p>
                      <p>3.http://example.com/en/phones/</p>
                      <p class="margin20px">After finishing generating the sitemap.xml, I would recommend commenting the foreach lines, since they are no longer necessary in the project and could cause problems with similar routes</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('createsitemap::sitemaps.title.create sitemaps') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.createsitemap.sitemaps.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
