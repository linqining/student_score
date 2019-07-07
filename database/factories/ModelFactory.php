<?php
use Faker\Generator as Faker;

$factory->define(App\Lesson::class, function (Faker $faker) {
    static $password;

    return [
        'title' => $faker->sentence,
        'body'  => $faker->paragraph,
        'free'  => $faker->boolean(),
    ];
});