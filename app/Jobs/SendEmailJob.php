<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use App\Mail\sendFirstEmail;
use App\Session;
use App\Teacher;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $session;
    protected $teacher;
    protected $user;
    protected $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Session $session, Teacher $teacher, User $user, $token)
    {
        $this->session = $session;
        $this->teacher = $teacher;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->teacher->email)->send(new SendEmail($this->session, $this->teacher, $this->user, $this->token));
    }
}
