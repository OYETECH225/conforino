<?php

namespace App\Livewire;

use App\Models\ContactRequest;
use App\Models\Service;
use App\Notifications\NewContactRequestNotification;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;

    // Étape 1 — projet & bénéficiaire
    public ?int $serviceId = null;

    public string $beneficiaryType = '';

    // Étape 2 — coordonnées & logement
    public string $name = '';

    public string $phone = '';

    public string $email = '';

    public string $city = '';

    public string $address = '';

    public string $propertyType = '';

    // Étape 3 — créneau souhaité
    public string $preferredDay = '';

    public string $preferredTimeSlot = '';

    // Étape 4 — détails & photos
    public string $message = '';

    /** @var array<\Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $photos = [];

    public bool $consent = false;

    public bool $submitted = false;

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'serviceId' => ['nullable', 'exists:services,id'],
                'beneficiaryType' => ['nullable', Rule::in(array_keys(ContactRequest::BENEFICIARY_TYPES))],
            ],
            2 => [
                'name' => ['required', 'string', 'max:120'],
                'phone' => ['required', 'string', 'max:20'],
                'email' => ['nullable', 'email', 'max:190'],
                'city' => ['nullable', 'string', 'max:120'],
                'address' => ['nullable', 'string', 'max:190'],
                'propertyType' => ['nullable', Rule::in(array_keys(ContactRequest::PROPERTY_TYPES))],
            ],
            3 => [
                'preferredDay' => ['nullable', 'string', 'max:60'],
                'preferredTimeSlot' => ['nullable', Rule::in(array_keys(ContactRequest::TIME_SLOTS))],
            ],
            4 => [
                'message' => ['nullable', 'string', 'max:2000'],
                'photos' => ['nullable', 'array', 'max:5'],
                'photos.*' => ['image', 'max:8192'],
                'consent' => ['accepted'],
            ],
            default => [],
        };
    }

    protected function messages(): array
    {
        return [
            'consent.accepted' => 'Merci de cocher la case de consentement pour que nous puissions vous recontacter.',
            'name.required' => 'Merci d\'indiquer votre nom.',
            'phone.required' => 'Merci d\'indiquer un numéro de téléphone.',
            'photos.*.image' => 'Chaque fichier doit être une image (JPG, PNG...).',
            'photos.*.max' => 'Chaque photo doit faire moins de 8 Mo.',
        ];
    }

    public function services()
    {
        return Service::query()->active()->ordered()->get();
    }

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step), $this->messages());
        $this->step = min(4, $this->step + 1);
    }

    public function previousStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function goToStep(int $step): void
    {
        if ($step < $this->step) {
            $this->step = $step;
        }
    }

    public function removePhoto(int $index): void
    {
        unset($this->photos[$index]);
        $this->photos = array_values($this->photos);
    }

    public function submit(): void
    {
        $this->validate($this->rulesForStep(4), $this->messages());

        $contactRequest = ContactRequest::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'city' => $this->city ?: null,
            'address' => $this->address ?: null,
            'property_type' => $this->propertyType ?: null,
            'service_id' => $this->serviceId,
            'beneficiary_type' => $this->beneficiaryType ?: null,
            'preferred_day' => $this->preferredDay ?: null,
            'preferred_time_slot' => $this->preferredTimeSlot ?: null,
            'message' => $this->message ?: null,
            'source_url' => url()->previous(),
            'consented_at' => now(),
        ]);

        foreach ($this->photos as $photo) {
            $contactRequest->addMedia($photo->getRealPath())
                ->usingFileName($photo->getClientOriginalName())
                ->toMediaCollection('photos');
        }

        $recipient = app(GeneralSettings::class)->email;

        if ($recipient) {
            Notification::route('mail', $recipient)
                ->notify(new NewContactRequestNotification($contactRequest));
        }

        $this->reset([
            'serviceId', 'beneficiaryType', 'name', 'phone', 'email', 'city', 'address',
            'propertyType', 'preferredDay', 'preferredTimeSlot', 'message', 'photos', 'consent', 'step',
        ]);
        $this->step = 1;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.contact-wizard', [
            'services' => $this->services(),
        ]);
    }
}
