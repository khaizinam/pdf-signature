<?php

namespace Dev\Contact\Http\Controllers;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Facades\EmailHandler;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Contact\Enums\CustomFieldType;
use Dev\Contact\Events\SentContactEvent;
use Dev\Contact\Forms\Fronts\ContactForm;
use Dev\Contact\Http\Requests\ContactRequest;
use Dev\Contact\Models\Contact;
use Dev\Contact\Models\CustomField;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PublicController extends BaseController
{
    public function postSendContact(ContactRequest $request)
    {
        $blacklistDomains = setting('blacklist_email_domains');

        if ($blacklistDomains) {
            $emailDomain = Str::after(strtolower($request->input('email')), '@');

            $blacklistDomains = collect(json_decode($blacklistDomains, true))->pluck('value')->all();

            if (in_array($emailDomain, $blacklistDomains)) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage(__('Your email is in blacklist. Please use another email address.'));
            }
        }

        $blacklistWords = trim(setting('blacklist_keywords', ''));

        if ($blacklistWords) {
            $content = strtolower($request->input('content'));

            $badWords = collect(json_decode($blacklistWords, true))
                ->filter(function ($item) use ($content) {
                    $matches = [];
                    $pattern = '/\b' . preg_quote($item['value'], '/') . '\b/iu';

                    return preg_match($pattern, $content, $matches, PREG_UNMATCHED_AS_NULL);
                })
                ->pluck('value')
                ->all();

            if (! empty($badWords)) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage(__('Your message contains blacklist words: ":words".', ['words' => implode(', ', $badWords)]));
            }
        }

        do_action('form_extra_fields_validate', $request, ContactForm::class);

        $receiverEmails = null;

        if ($receiverEmailsSetting = setting('receiver_emails', '')) {
            $receiverEmails = trim($receiverEmailsSetting);
        }

        if ($receiverEmails) {
            $receiverEmails = collect(json_decode($receiverEmails, true))
                ->pluck('value')
                ->all();
        }

        try {
            $form = ContactForm::create();

            $form->saving(function (ContactForm $form) use ($receiverEmails) {
                $data = $form->getRequestData();

                if (Arr::has($data, 'contact_custom_fields')) {
                    $customFields = CustomField::query()
                        ->wherePublished()
                        ->with('options')
                        ->get();

                    $data['custom_fields'] = collect($data['contact_custom_fields'])
                        ->mapWithKeys(function ($item, $id) use ($customFields) {
                            $field = $customFields->firstWhere('id', $id);
                            $options = $field->options->firstWhere('value', $item);

                            if (! $field) {
                                return [];
                            }

                            $value = match ($field->type->getValue()) {
                                CustomFieldType::CHECKBOX => $item ? __('Yes') : __('No'),
                                CustomFieldType::RADIO, CustomFieldType::DROPDOWN => $options?->label,
                                default => $item,
                            };

                            return [$field->name => $value];
                        })->all();
                }

                $form
                    ->getModel()
                    ->fill($data)
                    ->save();

                /**
                 * @var Contact $contact
                 */
                $contact = $form
                    ->getModel();

                event(new SentContactEvent($contact));

                $args = [];

                if ($contact->name && $contact->email) {
                    $args = ['replyTo' => [$contact->name => $contact->email]];
                }

                EmailHandler::setModule(CONTACT_MODULE_SCREEN_NAME)
                    ->setVariableValues([
                        'contact_name' => $contact->name,
                        'contact_subject' => $contact->subject,
                        'contact_email' => $contact->email,
                        'contact_phone' => $contact->phone,
                        'contact_address' => $contact->address,
                        'contact_content' => $contact->content,
                        'contact_custom_fields' => $data['custom_fields'] ?? [],
                    ])
                    ->sendUsingTemplate('notice', $receiverEmails ?: null, $args);
            });

            return $this
                ->httpResponse()
                ->setMessage(__('Send message successfully!'));
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            BaseHelper::logError($exception);

            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(__("Can't send message on this time, please try again later!"));
        }
    }
}
