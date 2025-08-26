<tfoot>
    <tr>
        @foreach($columns as $column)
            <td id="{{ $column }}"><span>{!! $column !!}</span></td>
        @endforeach
    </tr>
</tfoot>


