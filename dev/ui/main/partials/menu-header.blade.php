
<ul class="header-menu" {!! clean($options) !!}>
    @foreach ($menu_nodes as $key => $row)
        @if (!$row->has_child)
            <li>
                <a href="{{ $row->url }}">{{ $row->title }}</a>
            </li>
        @endif
    @endforeach
</ul>
