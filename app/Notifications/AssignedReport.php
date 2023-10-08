<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AssignedReport extends Notification
{
    use Queueable; 

    /**
     * Create a new notification instance.
     */
    protected $message;
    protected $notifURL;

    public function __construct($notifURL,$message)
    {
        $this->message = $message;
        $this->notifURL = $notifURL;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {

        // Create a new Carbon instance
        $carbon = new Carbon();

        // Set the timezone to 'Asia/Manila'
        $carbon->setTimezone('Asia/Manila');

        // Get the current time in the Philippines timezone and format it
        $formattedDate = $carbon->format('F j, Y \a\t h:i A');

        return [
            'data' => $this->message,
            'date' => $formattedDate,
            'notifURL' => $this->notifURL,
        ];
    }
}
