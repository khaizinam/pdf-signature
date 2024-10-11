@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="max-width-1200">
        {!! Form::open(['route' => ['auth.settings.update']]) !!}
        <x-core-setting::section
            :title="trans('libs/auth::auth.setting_title')"
            :description="trans('libs/auth::auth.setting_description')"
        >
            <x-core-setting::on-off
                name="auth_enabled"
                :label="trans('libs/auth::auth.auth_enabled')"
                :value="AuthHelper::enabled()"
            />
        </x-core-setting::section>

        <div class="flexbox-annotated-section" style="border: none">
            <div class="flexbox-annotated-section-annotation">&nbsp;</div>
            <div class="flexbox-annotated-section-content">
                <button class="btn btn-info" type="submit">{{ trans('libs/auth::auth.save_settings') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
