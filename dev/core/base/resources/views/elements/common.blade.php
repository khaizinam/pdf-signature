<script type="text/javascript">
    var AppVars = AppVars || {};

    @if (Auth::guard()->check())
        AppVars.languages = {
            tables: {{ Js::from(trans('core/base::tables')) }},
            notices_msg: {{ Js::from(trans('core/base::notices')) }},
            pagination: {{ Js::from(trans('pagination')) }},
        };
        AppVars.authorized =
            "{{ setting('membership_authorization_at') && Carbon\Carbon::now()->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', setting('membership_authorization_at'))) <= 7 ? 1 : 0 }}";
        AppVars.authorize_url = "{{ route('membership.authorize') }}";

        AppVars.menu_item_count_url = "{{ route('menu-items-count') }}";
    @else
        AppVars.languages = {
            notices_msg: {{ Js::from(trans('core/base::notices')) }},
        };
    @endif
</script>

@push('footer')
    @if (Session::has('success_msg') || Session::has('error_msg') || (isset($errors) && $errors->any()) || isset($error_msg))
        <script type="text/javascript">
            $(function() {
                @if (Session::has('success_msg'))
                    Apps.showSuccess('{!! BaseHelper::cleanToastMessage(session('success_msg')) !!}');
                @endif
                @if (Session::has('error_msg'))
                    Apps.showError('{!! BaseHelper::cleanToastMessage(session('error_msg')) !!}');
                @endif
                @if (isset($error_msg))
                    Apps.showError('{!! BaseHelper::cleanToastMessage($error_msg) !!}');
                @endif
                @if (isset($errors))
                    @foreach ($errors->all() as $error)
                        Apps.showError('{!! BaseHelper::cleanToastMessage($error) !!}');
                    @endforeach
                @endif
            })
        </script>
    @endif
@endpush
