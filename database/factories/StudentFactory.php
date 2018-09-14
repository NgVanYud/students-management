<?php

use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;
use App\Models\Auth\User;

$factory->define(User::class, function (Faker $faker) {
    $code = "AT".($faker->unique()->numberBetween(intval(120000), intval(150000)));
    return [
        'uuid' 			    => Uuid::generate(4)->string,
        'first_name'        => $faker->firstName,
        'last_name'         => $faker->lastName,
        'email'             => $faker->unique()->safeEmail,
        'password'          => 'secret',
        'password_changed_at' => null,
//        'remember_token'    => ,
        'confirmation_code' => md5(uniqid(rand(2345, 12345678), true)),
        'active' => 1,
        'confirmed' => 1,
        'gender' => rand(0, 1),
        'identity' => $faker->unique()->numberBetween(intval(1000000000), intval(200000000000)),
        'code' => $code,
        'username' => $code,
        'birthday' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});

