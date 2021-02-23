<div class="form-group ">
    <label class="col-md-{{$width['label']}} control-label">{{ $label }}</label>
    <div class="col-md-{{$width['field']}}">
        @if($wrapped)
        <div class="box box-solid box-default no-margin box-show">
            <!-- /.box-header -->
            <div class="box-body">
                @if($escape)
                    {{ $content }}
                @else
                    {!! $content !!}
                @endif
            </div><!-- /.box-body -->
        </div>
        @else
            @if($escape)
                {{ $content }}
            @else
                {!! $content !!}
            @endif
        @endif
    </div>
</div>