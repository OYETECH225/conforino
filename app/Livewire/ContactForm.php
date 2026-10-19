<?php

namespace App\Livewire;

use App\Models\ContactRequest;
use App\Notifications\NewContactRequestNotification;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $phone = '';

    public string $email = '';

    public string $city = '';

    public string $propertyType = '';

    public string $surface = '';

    public string $message = '';

    /**
     * Consentement explicite requis avant toute prise de contact commerciale
     * (loi du 30 juin 2025 sur le démarchage) : jamais pré-coché.
     */
    public bool $consent = false;

    public bool $submitted = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:190'],
            'city' => ['nullable', 'string', 'max:120'],
            'propertyType' => ['nullable', 'string', Rule::in(array_keys(ContactRequest::PROPERTY_TYPES))],
            'surface' => ['nullable', 'string', 'max:20'],
            'message' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ];
    }

    protected function messages(): array
    {
        return [
            'consent.accepted' => 'Merci de cocher la case de consentement pour que nous puissions vous recontacter.',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $contactRequest = ContactRequest::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'city' => $this->city ?: null,
            'property_type' => $this->propertyType ?: null,
            'surface' => $this->surface ?: null,
            'message' => $this->message ?: null,
            'source_url' => url()->previous(),
            'consented_at' => now(),
        ]);

        $recipient = app(GeneralSettings::class)->email;

        if ($recipient) {
            Notification::route('mail', $recipient)
                ->notify(new NewContactRequestNotification($contactRequest));
        }

        $this->reset(['name', 'phone', 'email', 'city', 'propertyType', 'surface', 'message', 'consent']);
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
