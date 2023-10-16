<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class FinishReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $message;
    protected $notifURL;
    protected $reportName;
    protected $creatorName;
    protected $creatorUser;
    protected $currentUserAuth;

    public function __construct($currentUserAuth, $creatorUser, $creatorName, $reportName, $notifURL, $message)
    {
        $this->message = $message;
        $this->notifURL = $notifURL;
        $this->reportName = $reportName;
        $this->creatorName = $creatorName;
        $this->creatorUser = $creatorUser;
        $this->currentUserAuth = $currentUserAuth;
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
        if ($notifiable == $this->currentUserAuth) {
            $message = 'You have successfully tagged the report \'' . $this->reportName . '\' as Finished.';
            $message2 = 'Check the link to view the report.';
        } 
        if ($notifiable == $this->creatorUser) {
            $message = 'Hi, ' . $this->creatorName . ', your report \'' . $this->reportName . '\' was tagged as Finished.';
            $message2 = 'Check the link to view your report.';
        }
    
        return (new MailMessage)
            ->greeting('Report Finished')
            ->line($message)
            ->action('View Report', $this->notifURL)
            ->line($message2);
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
