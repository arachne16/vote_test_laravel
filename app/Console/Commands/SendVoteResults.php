<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vote;
use DB;
use App\Jobs\SendVoteResultEmailJob;

class SendVoteResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-vote-results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send vote results';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // TODO: This ideally need to be chunked in order not to load db in case we have million questions.
        $groupedVotes = Vote::select('question', 'answer', DB::raw('COUNT(*) as count'))->groupBy('question', 'answer')->get();

        $result = [];
        foreach ($groupedVotes->groupBy('question') as $question => $votesByQuestion) {
            $result[$question] = "";
            foreach ($votesByQuestion as $vote) {
                $result[$question] .= $vote->answer . ':' . $vote->count . ';';
            }
        }

        // SendVoteResultEmailJob::dispatch('testtask@gmail.com', $result);
        SendVoteResultEmailJob::dispatch('dev@steadfastcollective.com', $result);
    }
}
