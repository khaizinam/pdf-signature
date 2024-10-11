<ol class="dd-list">
    @foreach ($menu_nodes->loadMissing('metadata') as $key => $row)
        @include('libs/menu::partials.node')
    @endforeach
</ol>
