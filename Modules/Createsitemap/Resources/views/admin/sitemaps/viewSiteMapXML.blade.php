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

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                </div>
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
