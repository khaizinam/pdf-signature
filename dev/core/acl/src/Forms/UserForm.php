<?php

namespace Dev\ACL\Forms;

use Dev\ACL\Http\Requests\CreateUserRequest;
use Dev\ACL\Models\Role;
use Dev\ACL\Models\User;
use Dev\Base\Forms\FieldOptions\EmailFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;

class UserForm extends FormAbstract
{
    public function setup(): void
    {
        $roles = Role::query()->pluck('name', 'id');

        $defaultRole = $roles->where('is_default', 1)->first();

        $this
            ->model(User::class)
            ->setValidatorClass(CreateUserRequest::class)
            ->columns()
            ->add(
                'first_name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('core/acl::users.info.first_name'))
                    ->required()
                    ->maxLength(30)
                    ->toArray()
            )
            ->add(
                'last_name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('core/acl::users.info.last_name'))
                    ->required()
                    ->maxLength(30)
                    ->toArray()
            )
            ->add(
                'username',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('core/acl::users.username'))
                    ->required()
                    ->maxLength(30)
                    ->toArray()
            )
            ->add('email', TextField::class, EmailFieldOption::make()->required()->toArray())
            ->add(
                'password',
                'password',
                TextFieldOption::make()
                    ->label(trans('core/acl::users.password'))
                    ->required()
                    ->maxLength(60)
                    ->colspan(2)
                    ->toArray()
            )
            ->add(
                'password_confirmation',
                'password',
                TextFieldOption::make()
                    ->label(trans('core/acl::users.password_confirmation'))
                    ->required()
                    ->maxLength(60)
                    ->colspan(2)
                    ->toArray()
            )
            ->add(
                'role_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('core/acl::users.role'))
                    ->choices(['' => trans('core/acl::users.select_role')] + $roles->all())
                    ->when($defaultRole, fn (SelectFieldOption $option) => $option->selected($defaultRole->id))
                    ->toArray()
            )
            ->setBreakFieldPoint('role_id');
    }
}
