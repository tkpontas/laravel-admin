<table {!! $attributes !!}>
    <thead>
    <tr>
        @foreach($headers as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
    <tr>
        @foreach($row as $item)
        <td {!! count($columnStyle) > $loop->index ? 'style="' . $columnStyle[$loop->index] . '";' : '' !!}>{!! $item !!}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>