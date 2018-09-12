<?php

use Faker\Generator as Faker;
use Cviebrock\EloquentSluggable\Services\SlugService;

$factory->define(\App\Models\Subject::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text(40),
        'credit' => $faker->randomDigitNotNull,
        'abbreviation' => strtoupper($faker->unique(true)->text(10)),
        'is_actived' => 1
    ];
});
