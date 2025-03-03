<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label text-lg-end pt-2">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <input type="text" class="{{$class}}" name="{{$name}}" data-from="{{ $old }}" {!! $attributes !!} />

        @include('admin::form.help-block')

    </div>
</div>
