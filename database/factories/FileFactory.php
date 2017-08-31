<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

$factory->define(App\File::class, function (Faker $faker) {
    return [
        'body' => Storage::url('plain_upload.txt'),
    ];
});
