<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewVoteNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vote;
    public $owner;
    public $voteDetail;

    /**
     * Create a new message instance.
     */
    public function __construct($vote, $owner , $voteDetail)
    {
        $this->vote  = $vote;
        $this->owner = $owner;
        $this->voteDetail = $voteDetail;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('test@edarat.com', config('app.name'))
                    ->subject('إشعار تصويت جديد')
                    ->markdown('emails.votes.new_vote', [
                        'vote' => $this->vote,
                        'owner' => $this->owner,
                        'voteDetail' => $this->voteDetail,
                    ]);
    }

}
