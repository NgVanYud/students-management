<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Chapter::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text(60),
        'is_actived' => 1,
    ];
});
