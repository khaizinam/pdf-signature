<?php

namespace Dev\Api\Forms;

use Dev\Api\Http\Requests\StoreSanctumTokenRequest;
use Dev\Api\Models\PersonalAccessToken;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;

class SanctumTokenForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new PersonalAccessToken())
            ->setValidatorClass(StoreSanctumTokenRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->toArray());
    }
}
