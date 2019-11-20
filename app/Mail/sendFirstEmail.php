<?php

namespace App\Mail;

use App\Session;
use App\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendFirstEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $session;
    protected $teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Session $session, Teacher $teacher)
    {
        $this->session = $session;
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sendFirstEmail', ['session' => $this->session, 'teacher' => $this->teacher]);
    }
}
