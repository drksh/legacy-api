<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Submission;
use App\Url;

class SubmissionsController extends Controller
{
    public function store() {

        $content = Url::create(request()->only('body'));
        $submission = Submission::create([
            'content_id' => $content->id,
            'content_type' => 'url',
        ]);

        return response([
            'type' => $submission->content_type,
            'body' => $submission->content->body,
            'url' => url($submission->slug),
        ], 201);
    }
}
