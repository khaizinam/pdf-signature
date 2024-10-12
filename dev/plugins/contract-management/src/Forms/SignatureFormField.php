<?php

namespace Dev\ContractManagement\Forms;

use Kris\LaravelFormBuilder\Fields\FormField;

class SignatureFormField extends FormField
{
 /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'plugins/contract-management::list-signature';
    }
}
