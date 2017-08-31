<?php

namespace App\Observers;

use App\Submission;

class SubmissionObserver
{
    /**
     * Listen for when a Submission is being created.
     *
     * @param  Submission  $submission
     * @return void
     */
    public function creating(Submission $submission)
    {
        $slug = app('slugger')->encode(Submission::count() + 1);

        $submission->slug = $slug;
    }
}
