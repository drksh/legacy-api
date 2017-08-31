<?php

use Faker\Generator as Faker;

$factory->define(App\Submission::class, function (Faker $faker) use ($factory) {
    $content = $factory->create(App\Url::class);

    return [
        'content_id' => $content->id,
        'content_type' => 'url',
    ];
});

$factory->defineAs(
    App\Submission::class,
    'url',
    function (Faker $faker) use ($factory) {
        $defaults = $factory->raw(App\Submission::class);

        return array_merge($defaults, []);
    }
);
