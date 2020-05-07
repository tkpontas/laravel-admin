<table {!! $attributes !!}>
    <thead>
    <tr>
        @foreach($headers as $header)
            <th
                {!! count($columnClasses) > $loop->index ? 'class="' . $columnClasses[$loop->index] . '"' : '' !!}
            >{{ $header }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
    <tr>
        @foreach($row as $item)
        <td 
            {!! count($columnStyle) > $loop->index ? 'style="' . $columnStyle[$loop->index] . '"' : '' !!}
            {!! count($columnClasses) > $loop->index ? 'class="' . $columnClasses[$loop->index] . '"' : '' !!}
        >{!! $item !!}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>