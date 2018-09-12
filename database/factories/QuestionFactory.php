<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Question::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph(3, true),
        'is_actived' => 1,
        'creater_id' => 1,
    ];
});
