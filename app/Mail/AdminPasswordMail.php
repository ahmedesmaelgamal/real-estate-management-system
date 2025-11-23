<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;


class AdminPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $resetLink;

    public function __construct($data)
    {
        $this->data = $data;
        $admin_id = Crypt::encrypt($data['id']);
        $this->resetLink = URL::temporarySignedRoute(
            'admin.password.generate',
            now()->addHour(),
            ['id' => $admin_id]
        );
    }

    public function build()
    {
        return $this->subject('Set Your Password')
                    ->view('mail.userPasswordMail')
                    ->with([
                        'name' => $this->data['name'],
                        'resetLink' => $this->resetLink,
                    ]);
    }

}
