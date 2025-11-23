<?php

namespace App\Listeners;

use App\Events\CheckVote;
use App\Jobs\CheckVoteJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RunVotesCheck
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CheckVote $event): void
    {
        CheckVoteJob::dispatch();
    }
}
