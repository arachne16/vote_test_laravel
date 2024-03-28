<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Jobs\StoreVoteJob;
use App\Repositories\VoteRepository;

class VoteController extends Controller
{
    public function __construct(private VoteRepository $voteRepository)
    {
    }
    /**
     * Answer on a question in vote
     */
    public function create(Request $request): Response
    {
        $user = $request->user();

        $question = 'What is your favorite color?';
        $options = ['Red', 'Blue', 'Green', 'Yellow'];

        return Inertia::render('Vote/Create', [
            'question' => $question,
            'options' => $options,
            'mustVerifyEmail' => empty($user->email_verified_at),
            'status' => session('status'),
            'alreadyVoted' => !session('success') && $this->voteRepository->alreadyVoted($user->id, $question)
        ]);
    }

    /**
     * Store vote result
     */
    public function store(VoteStoreRequest $request): RedirectResponse
    {
        $storeVoteJob = new StoreVoteJob(
            userId: auth()->user()->id,
            ip: $request->ip(),
            question: $request->question,
            answer: $request->answer
        );

        dispatch($storeVoteJob);

        session()->flash('success', true);

        return Redirect::route('vote.create');
    }
}
