<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Chapter::class, $subject_id,function (Faker $faker) use ($subject_id) {
    return [
        'name' => $faker->text(60),
        'subject_id' => $subject_id,
        'is_actived' => 1,
    ];
});
