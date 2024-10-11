@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <x-core::form
        :url="route('auth.settings.update')"
        method="post"
    >
        <x-core-setting::section
            :title="trans('libs/auth::auth.setting_title')"
            :description="trans('libs/auth::auth.setting_description')"
        >
            <x-core::form.on-off.checkbox
                name="auth_enabled"
                :label="trans('libs/auth::auth.auth_enabled')"
                :checked="AuthHelper::enabled()"
            />
        </x-core-setting::section>

        <x-core-setting::section.action>
            <x-core::button
                type="submit"
                color="primary"
                icon="ti ti-device-floppy"
            >
                {{ trans('libs/auth::auth.save_settings') }}
            </x-core::button>
        </x-core-setting::section.action>
    </x-core::form>
@endsection
