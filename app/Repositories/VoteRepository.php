<?php

namespace App\Repositories;

use App\Models\Vote;

class VoteRepository
{
    public function alreadyVoted(
        int $userId,
        string $question,
    ): bool {
        return Vote::where('user_id', $userId)->where('question', $question)->exists();
    }

    public function storeVote(
        int $userId,
        string $question,
        string $answer,
        string $ip,
        ?string $locationCity,
        ?string $locationCountry
    ): Vote {

        return Vote::create([
            'user_id' => $userId,
            'question' => $question,
            'answer' => $answer,
            'ip' => $ip,
            'location_country' => $locationCity,
            'location_city' => $locationCountry,
        ]);
    }
}
