<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Submission;
use App\Url;

class SubmissionsController extends Controller
{
    /**
     * Read a submission.
     *
     * @param Submission $submission
     *
     * @return Illuminate\Http\Response
     */
    public function show(Submission $submission)
    {
        return response([
            'type' => $submission->content_type,
            'body' => $submission->content->body,
        ]);
    }

    /**
     * Store a submission.
     *
     * @return Illuminate\Http\Response
     */
    public function store()
    {
        $submission = Submission::createFromType(request('type'), [
            'body' => request('body'),
        ]);

        return response([
            'type' => $submission->content_type,
            'body' => $submission->content->body,
            'url' => url($submission->slug),
        ], 201);
    }

    /**
     * Update a submission
     *
     * @return Illuminate\Http\Response
     */
    public function update()
    {
        return $this->notImplementedResponse();
    }

    /**
     * Destroy a submission.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy()
    {
        return $this->notImplementedResponse();
    }

    /**
     * Return a reponse that tells the user that
     * the endpoint is not implemented.
     *
     * @return Illuminate\Http\Response
     */
    private function notImplementedResponse()
    {
        return response([
            'message' => 'Sorry, not implemented.',
        ], 501);
    }

}
