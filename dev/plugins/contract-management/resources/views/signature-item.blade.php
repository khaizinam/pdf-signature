
@if (!empty($values) && count($values) > 0)
    <ul class="list-group">
        @foreach($values as $item)
            <li class="list-group-item mb-3 container">
                <div class="row">
                    <div class="col-md-1 d-flex flex-column">
                        <strong class="mb-2">ID:</strong>
                        <span>#{{  Arr::get($item, 'id','') }}</span>
                    </div>
                    <div class="col-md-5 d-flex flex-column">
                        <strong class="mb-2">Họ và tên:</strong>
                        <span>{{  Arr::get($item, 'name','') }}</span>
                    </div>
                    <div class="col-md-4 d-flex flex-column">
                        <strong class="mb-2">Ngày kí: </strong>
                        <span>{{ Arr::get($item, 'created_at','') }}</span>
                    </div>
                    <div class="col-md-2 d-flex flex-column">
                        <a href="{{get_object_image(Arr::get($item, 'file',''))}}" target="__blank">Xem tệp</a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif

