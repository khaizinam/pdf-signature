<?php

namespace Dev\Table\Http\Controllers;

use Dev\ACL\Models\User;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Rules\OnOffRule;
use Illuminate\Http\Request;

class TableColumnVisibilityController extends BaseController
{
    public function update(Request $request)
    {
        $request->validate([
            'columns_visibility' => ['required', 'array'],
            'columns_visibility.*' => new OnOffRule(),
            'table' => ['required', 'string'],
        ]);

        $table = $request->input('table');

        if (! class_exists($table)) {
            return $this->httpResponse()->setError();
        }

        /**
         * @var User $user
         */
        $user = $request->user();

        $userVisibility = $user->getMeta('datatable_columns_visibility');

        $visibility = $userVisibility ? json_decode($userVisibility, true) : [];

        $visibility[$table] = $request->input('columns_visibility');

        $user->setMeta('datatable_columns_visibility', json_encode($visibility));

        return $this->httpResponse()->withUpdatedSuccessMessage();
    }
}
