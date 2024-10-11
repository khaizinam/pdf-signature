<?php

namespace Dev\Setting\Http\Requests;

use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class DataTableSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'datatables_default_show_column_visibility' => $onOffRule = new OnOffRule(),
            'datatables_default_show_export_button' => $onOffRule,
            'datatables_pagination_type' => ['nullable', Rule::in(['dropdown'])],
        ];
    }
}
