<?php

use Faker\Generator as Faker;
use Cviebrock\EloquentSluggable\Services\SlugService;

$factory->define(\App\Models\Subject::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'credit' => $faker->randomDigitNotNull,
        'abbreviation' => strtoupper($faker->word),
        'is_actived' => 1
    ];
});
