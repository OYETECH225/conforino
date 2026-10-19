<?php

namespace App\Notifications;

use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactRequestNotification extends Notification
{
    use Queueable;

    public function __construct(public ContactRequest $contactRequest) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $contact = $this->contactRequest;

        return (new MailMessage)
            ->subject('Nouvelle demande de devis — '.$contact->name)
            ->greeting('Nouvelle demande de devis reçue sur le site')
            ->line('Nom : '.$contact->name)
            ->line('Téléphone : '.$contact->phone)
            ->when($contact->email, fn ($mail) => $mail->line('Email : '.$contact->email))
            ->when($contact->city, fn ($mail) => $mail->line('Ville : '.$contact->city))
            ->when($contact->address, fn ($mail) => $mail->line('Adresse : '.$contact->address))
            ->when($contact->property_type, fn ($mail) => $mail->line('Type de bien : '.(ContactRequest::PROPERTY_TYPES[$contact->property_type] ?? $contact->property_type)))
            ->when($contact->surface, fn ($mail) => $mail->line('Surface : '.$contact->surface.' m²'))
            ->when($contact->service, fn ($mail) => $mail->line('Prestation demandée : '.$contact->service->title))
            ->when($contact->beneficiary_type, fn ($mail) => $mail->line('Demande pour : '.(ContactRequest::BENEFICIARY_TYPES[$contact->beneficiary_type] ?? $contact->beneficiary_type)))
            ->when($contact->preferred_day, fn ($mail) => $mail->line('Jour préférentiel : '.$contact->preferred_day))
            ->when($contact->preferred_time_slot, fn ($mail) => $mail->line('Créneau souhaité : '.(ContactRequest::TIME_SLOTS[$contact->preferred_time_slot] ?? $contact->preferred_time_slot)))
            ->when($contact->message, fn ($mail) => $mail->line('Message : '.$contact->message))
            ->when($contact->getMedia('photos')->isNotEmpty(), fn ($mail) => $mail->line($contact->getMedia('photos')->count().' photo(s) jointe(s), consultables dans l\'admin.'))
            ->line('Page d\'origine : '.($contact->source_url ?: '—'))
            ->action('Voir dans l\'admin', url('/admin/contact-requests/'.$contact->id.'/edit'));
    }
}
