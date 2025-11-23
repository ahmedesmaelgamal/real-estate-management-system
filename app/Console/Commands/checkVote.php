<?php

namespace App\Console\Commands;

use App\Jobs\CheckVoteJob;
use Illuminate\Console\Command;

class CheckVote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:vote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto check for the votes status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // app()->call('App\Http\Controllers\Admin\VotesController@checkVotes');
        CheckVoteJob::dispatch();

        \Log::info('Votes check executed successfully!');
    }
}
