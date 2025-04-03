<div class="box card">

    <div class="box-header px-3 pt-3">
        @if($title)
        <h3 class="box-title">{{$title}}</h3>
        @endif

        @if($useExpandCollapse)
        <div class="btn-group">
            <a class="btn btn-primary btn-sm {{ $id }}-tree-tools" data-action="expand" title="{{ trans('admin.expand') }}">
                <i class="fa fa-plus-square-o"></i>&nbsp;{{ trans('admin.expand') }}
            </a>
            <a class="btn btn-primary btn-sm {{ $id }}-tree-tools" data-action="collapse" title="{{ trans('admin.collapse') }}">
                <i class="fa fa-minus-square-o"></i>&nbsp;{{ trans('admin.collapse') }}
            </a>
        </div>
        @endif

        @if($useSave)
        <div class="btn-group">
            <a class="btn btn-info btn-sm {{ $id }}-save" title="{{ trans('admin.save') }}"><i class="fa fa-save"></i><span class="d-none d-md-inline">&nbsp;{{ trans('admin.save') }}</span></a>
        </div>
        @endif

        @if($useRefresh)
        <div class="btn-group">
            <a class="btn btn-warning btn-sm {{ $id }}-refresh text-white" title="{{ trans('admin.refresh') }}"><i class="fa fa-refresh"></i><span class="d-none d-md-inline">&nbsp;{{ trans('admin.refresh') }}</span></a>
        </div>
        @endif

        <div class="btn-group">
            {!! $tools !!}
        </div>

        @if($useCreate)
        <div class="btn-group pull-right">
            <a class="btn btn-success btn-sm" href="{{ $path }}/create"><i class="fa fa-save"></i><span class="d-none d-md-inline">&nbsp;{{ trans('admin.new') }}</span></a>
        </div>
        @endif

    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding p-1">
        <div class="dd" id="{{ $id }}">
            <ol class="dd-list">
                @each($branchView, $items, 'branch')
            </ol>
        </div>
    </div>
    <!-- /.box-body -->
</div>
