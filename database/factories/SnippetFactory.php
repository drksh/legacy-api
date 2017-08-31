<?php

use Faker\Generator as Faker;

$factory->define(App\Snippet::class, function (Faker $faker) {
    return [
        'body' => $faker->realText
    ];
});
