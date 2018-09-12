<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Answer::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph(2, true),
        'is_correct' => rand(0, 1),
    ];
});
