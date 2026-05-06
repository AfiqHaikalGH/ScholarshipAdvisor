<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeadlineReminder extends Notification
{
    use Queueable;

    public $application;
    public $scholarshipName;
    public $deadline;

    /**
     * Create a new notification instance.
     */
    public function __construct($application, $scholarshipName, $deadline)
    {
        $this->application = $application;
        $this->scholarshipName = $scholarshipName;
        $this->deadline = $deadline;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'scholarship_name' => $this->scholarshipName,
            'message' => "Reminder: The deadline for {$this->scholarshipName} is approaching on " . \Carbon\Carbon::parse($this->deadline)->format('d M Y') . ". Please make sure to upload your proof of application.",
        ];
    }
}
