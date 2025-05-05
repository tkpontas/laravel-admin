
@if($enableHeader ?? true)
<div class="row">
    <div class="col-sm-12">
        <h4 class="field-header">{{ $label }}</h4>
    </div>
    <hr style="margin-top: 0px;">
</div>
@endif

<div id="has-many-{{$column}}" class="hasmanyblock-{{$column}} has-many-{{$column}}" {!! $attributes !!} >

    <div class="has-many-{{$column}}-forms">

        @foreach($forms as $pk => $form)

            <div class="has-many-{{$column}}-form has-many-form fields-group box-header with-border mb-3">

                @foreach($form->fields() as $field)
                    {!! $field->render() !!}
                @endforeach

                @if($options['allowDelete'])
                <div class="form-group">
                    <label class="{{$viewClass['label']}} control-label text-lg-end pt-2"></label>
                    <div class="{{$viewClass['field']}} offset-2 pb-5">
                        <div class="remove btn btn-warning btn-sm float-end"><i class="fa fa-trash">&nbsp;</i>{{ trans('admin.remove') }}</div>
                    </div>
                    
                </div>
                @endif
            </div>
        @endforeach
    </div>
    

    <template class="{{$column}}-tpl">
        <div class="has-many-{{$column}}-form has-many-form fields-group box-header with-border mb-3">

            {!! $template !!}

            <div class="form-group">
                <label class="{{$viewClass['label']}} control-label text-lg-end pt-2"></label>
                <div class="{{$viewClass['field']}} offset-2 pb-5">
                    <div class="remove btn btn-warning btn-sm float-end"><i class="fa fa-trash"></i>&nbsp;{{ trans('admin.remove') }}</div>
                </div>
            </div>
        </div>
    </template>

    @if($options['allowCreate'])
    <div class="form-group">
        <label class="{{$viewClass['label']}} control-label text-lg-end pt-2"></label>
        <div class="{{$viewClass['field']}} offset-md-2 ps-1 pb-3">
            <div class="add btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;{{ trans('admin.new') }}</div>
        </div>
    </div>
    @endif

</div>