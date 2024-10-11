<?php

namespace Dev\Contact\Forms;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\FormAbstract;
use Dev\Contact\Enums\ContactStatusEnum;
use Dev\Contact\Http\Requests\EditContactRequest;
use Dev\Contact\Models\Contact;

class ContactForm extends FormAbstract
{
    public function setup(): void
    {
        Assets::addScriptsDirectly('vendor/core/plugins/contact/js/contact.js')
            ->addStylesDirectly('vendor/core/plugins/contact/css/contact.css');

        $this
            ->model(Contact::class)
            ->setValidatorClass(EditContactRequest::class)
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make()
                    ->choices(ContactStatusEnum::labels())
                    ->toArray()
            )
            ->setBreakFieldPoint('status')
            ->addMetaBoxes([
                'information' => [
                    'title' => trans('plugins/contact::contact.contact_information'),
                    'content' => view('plugins/contact::contact-info', ['contact' => $this->getModel()])->render(),
                ],
                'replies' => [
                    'title' => trans('plugins/contact::contact.replies'),
                    'content' => view('plugins/contact::reply-box', ['contact' => $this->getModel()])->render(),
                ],
            ]);
    }
}
