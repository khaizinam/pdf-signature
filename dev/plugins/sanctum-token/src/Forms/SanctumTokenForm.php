<?php

namespace Dev\SanctumToken\Forms;

use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\SanctumToken\Http\Requests\StoreSanctumTokenRequest;
use Dev\SanctumToken\Models\PersonalAccessToken;

class SanctumTokenForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new PersonalAccessToken())
            ->setValidatorClass(StoreSanctumTokenRequest::class)
            ->add('name', TextField::class, TextFieldOption::make()->label(__('core/base::tables.name'))->toArray());
    }
}
