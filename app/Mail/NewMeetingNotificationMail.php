<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMeetingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;
    public $owner;

    /**
     * Create a new message instance.
     */
    public function __construct($meeting, $owner)
    {
        $this->meeting = $meeting;
        $this->owner   = $owner;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('إشعار اجتماع جديد 📅')
                    ->markdown('emails.meetings.new_meeting');
    }
}
