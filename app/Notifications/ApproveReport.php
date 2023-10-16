<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class ApproveReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $message;
    protected $notifURL;
    protected $reportName;
    protected $creatorName;

    public function __construct($creatorName, $reportName, $notifURL, $message)
    {
        $this->message = $message;
        $this->notifURL = $notifURL;
        $this->reportName = $reportName;
        $this->creatorName = $creatorName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Report Approved')
                    ->line('Hi, ' . $this->creatorName . '. Your report \'' . $this->reportName . '\' was Approved.' )
                    ->action('View Report', $this->notifURL)
                    ->line('Check the link to view your report.');
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
