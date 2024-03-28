<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVoteResultEmail;

class SendVoteResultEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $recipient, private array $voteResults)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->recipient)->send(new SendVoteResultEmail($this->voteResults));
    }
}
