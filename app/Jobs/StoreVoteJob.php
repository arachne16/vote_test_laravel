<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\VoteRepository;
use Illuminate\Support\Facades\Log;

class StoreVoteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $userId, private ?string $ip, private string $question, private string $answer)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var VoteRepository $voteRepository */
        $voteRepository = app(VoteRepository::class);

        if ($voteRepository->alreadyVoted($this->userId, $this->question)) {
            
            Log::debug('The user votes for the same question again. Skipping...', [
                'user_id' => $this->userId,
                'question' => $this->question
            ]);

            return;
        }

        $location = geoip()->getLocation($this->ip);

        $voteRepository->storeVote(
            userId: $this->userId,
            question: $this->question,
            answer: $this->answer,
            ip: $this->ip,
            locationCountry: $location->city ?? null,
            locationCity: $location->country ?? null,
        );
    }
}
