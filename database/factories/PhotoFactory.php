<?php

use Faker\Generator as Faker;

$factory->define(App\Photo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'photo' => 'random-image.jpg'
    ];
});
