<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $status, $request, $date, $subject, $details)
    {
        $this->user = $user;
        $this->status = $status;
        $this->request = $request;
        $this->date = $date;
        $this->subject = $subject;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.newmail2')
            ->from('announcement@tiftci.org', 'Appointment Updates')
            ->subject($this->subject)
            ->with([
                'user' => $this->user,
                'status' => $this->status,
                'request' => $this->request,
                'date' => $this->date,
                'details' => $this->details,
            ]);
    }
}
