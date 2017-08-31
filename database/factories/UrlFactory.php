<?php

use Faker\Generator as Faker;

$factory->define(App\Url::class, function (Faker $faker) {
    return [
        'body' => $faker->url,
    ];
});
