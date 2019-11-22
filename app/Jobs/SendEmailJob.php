<?php

namespace App\Jobs;

use App\Mail\sendFirstEmail;
use App\Session;
use App\Teacher;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Session $session, Teacher $teacher)
    {
        $this->session = $session;
        $this->teacher = $teacher;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->teacher->email)->send(new sendFirstEmail($this->session, $this->teacher));
    }
}
