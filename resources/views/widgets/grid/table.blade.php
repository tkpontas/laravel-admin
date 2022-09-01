<div class="box">
    @if ( $grid->showTools() || $grid->showExportBtn() || $grid->showCreateBtn() )
    <div class="box-header with-border">
        <div class="pull-right">
            {!! $grid->renderColumnSelector() !!}
            {!! $grid->renderCreateButton() !!}
        </div>
        @if ( $grid->showTools() )
        @include('admin::grid.tools')
        @endif
    </div>
    @endif

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover" id="{{ $grid->tableID }}">
            <thead>
                <tr>
                    @foreach($grid->visibleColumns() as $column)
                    <th class="column-{!! $column->getName() !!}">{{$column->getLabel()}}{!! $column->sorter() !!}{!! $column->help() !!}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach($grid->rows() as $row)
                <tr>
                    @foreach($grid->visibleColumnNames() as $name)
                    <td {!! $row->getColumnAttributes($name) !!} class="{!! $row->getColumnClasses($name) !!}">
                        {!! $row->column($name) !!}
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="box-footer table-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
</div>
