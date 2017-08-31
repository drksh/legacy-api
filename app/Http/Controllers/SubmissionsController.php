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
        if (request('type') === 'url') {
            $content = Url::create(request()->only('body'));
        } else if (request('type') === 'snippet') {
            $content = Snippet::create(request()->only('body'));
        } else if (request('type') === 'file') {
            $file = request()->file('body');
            $file->store('', 'void');

            $content = File::create([
                'body' => Storage::disk('void')->url($file->hashName()),
            ]);
        }

        $submission = Submission::create([
            'content_id' => $content->id,
            'content_type' => request('type'),
        ]);

        return response([
            'type' => $submission->content_type,
            'body' => $submission->content->body,
            'url' => url($submission->slug),
        ], 201);
    }
}
