<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Submission;
use App\Snippet;
use App\File;
use App\Url;
use Illuminate\Support\Facades\Storage;

class SubmissionsController extends Controller
{
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
}
