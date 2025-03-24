<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

<label for="{{$id}}" class="{{$viewClass['label']}} control-label text-lg-end pt-2">{{$label}}</label>

    <div class="{{$viewClass['field']}} ">

        @include('admin::form.error')

        <input type="hidden" name="{{$name}}"/>

        <select class="form-control {{$class}}" style="width: 100%;" name="{{$name}}" {!! $attributes !!} >
            @if($groups)
                @if($addEmpty)
                    <option value=""></option>
                @endif
                @foreach($groups as $group)
                    <optgroup label="{{ $group['label'] }}">
                        @foreach($group['options'] as $select => $option)
                            <option value="{{$select}}" {{ $select == $old ?'selected':'' }}>{{$option}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
             @else
                @if($addEmpty)
                    <option value=""></option>
                @endif
                @foreach($options as $select => $option)
                    <option value="{{$select}}" {{ $select == $old ?'selected':'' }}>{{$option}}</option>
                @endforeach
            @endif
        </select>

        @if(!empty($buttons))
        <div style="margin:0.2em 0 0.5em;">
            @foreach($buttons as $button)
            <button type="button" class="btn btn-sm {{array_get($button, 'btn_class', 'btn-default')}}" {!! array_get($button, 'attribute') !!}>
                <i class="fa {{array_get($button, 'icon')}}"></i>&nbsp;{{array_get($button, 'label')}}
            </button>
            @endforeach
        </div>
        @endif

        @include('admin::form.help-block')

    </div>
</div>
