@extends(BaseHelper::getAdminMasterLayoutTemplate())

@push('header')
    {!! AppMedia::renderHeader() !!}
@endpush

@section('content')
    {!! AppMedia::renderContent() !!}
@endsection

@push('footer')
    {!! AppMedia::renderFooter() !!}
@endpush
