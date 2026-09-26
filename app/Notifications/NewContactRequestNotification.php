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
            ->when($contact->message, fn ($mail) => $mail->line('Message : '.$contact->message))
            ->line('Page d\'origine : '.($contact->source_url ?: '—'))
            ->action('Voir dans l\'admin', url('/admin/contact-requests/'.$contact->id.'/edit'));
    }
}
