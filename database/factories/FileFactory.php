<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

$factory->define(App\File::class, function (Faker $faker) {
    $filename = "{$faker->md5}.{$faker->fileExtension}";

    return [
        'body' => Storage::disk('void')->url($filename),
    ];
});
