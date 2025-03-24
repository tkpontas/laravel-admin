<div class="{{$viewClass['form-group']}} {!! ($errors->has($errorKey['start'].'start') || $errors->has($errorKey['end'].'end')) ? 'has-error' : ''  !!}">

    <label for="{{$id['start']}}" class="{{$viewClass['label']}} control-label text-lg-end pt-2">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="row" style="width: 525px; max-width:100%;">
            <div class="col-lg-5">
                <div class="input-group">
                    <span class="input-group-text d-flex align-items-center"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="{{$name['start']}}" value="{{ $old['start'] }}" class="form-control {{$class['start']}}" {!! $attributes !!} />
                </div>
            </div>

            <div class="col-lg-2" style="text-align:center; line-height:34px;">
                ～
            </div>

            <div class="col-lg-5">
                <div class="input-group">
                    <span class="input-group-text d-flex align-items-center"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="{{$name['end']}}" value="{{ $old['end'] }}" class="form-control {{$class['end']}}" {!! $attributes !!} />
                </div>
            </div>
        </div>

        @include('admin::form.help-block')

    </div>


</div>
