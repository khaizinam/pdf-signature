@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="max-width-1200">
        {!! Form::open(['route' => ['advanced-role.settings.update']]) !!}
        <x-core-setting::section
            :title="trans('libs/advanced-role::advanced-role.setting_title')"
            :description="trans('libs/advanced-role::advanced-role.setting_description')"
        >
            <x-core-setting::on-off
                name="advanced-role_enabled"
                :label="trans('libs/advanced-role::advanced-role.advanced-role_enabled')"
                :value="AdvancedRoleHelper::enabled()"
            />
        </x-core-setting::section>

        <div class="flexbox-annotated-section" style="border: none">
            <div class="flexbox-annotated-section-annotation">&nbsp;</div>
            <div class="flexbox-annotated-section-content">
                <button class="btn btn-info" type="submit">{{ trans('libs/advanced-role::advanced-role.save_settings') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
