@if(isset($uniqueName))
<div class="{{$uniqueName}}">
@endif

@foreach($fields as $field)
    {!! $field->render() !!}
@endforeach

@if(isset($uniqueName))
</div>
@endif
