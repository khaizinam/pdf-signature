@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <x-core::form
        :url="route('advanced-role.settings.update')"
        method="post"
    >
        <x-core-setting::section
            :title="trans('libs/advanced-role::advanced-role.setting_title')"
            :description="trans('libs/advanced-role::advanced-role.setting_description')"
        >
            <x-core::form.on-off.checkbox
                name="advanced-role_enabled"
                :label="trans('libs/advanced-role::advanced-role.advanced-role_enabled')"
                :checked="AdvancedRoleHelper::enabled()"
            />
        </x-core-setting::section>

        <x-core-setting::section.action>
            <x-core::button
                type="submit"
                color="primary"
                icon="ti ti-device-floppy"
            >
                {{ trans('libs/advanced-role::advanced-role.save_settings') }}
            </x-core::button>
        </x-core-setting::section.action>
    </x-core::form>
@endsection
