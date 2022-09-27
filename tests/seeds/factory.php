<?php

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

$factory = app(Factory::class);

$factory->definition(Tests\Models\User::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'email'    => $faker->email,
        'mobile'   => $faker->phoneNumber,
        'avatar'   => $faker->imageUrl(),
        'password' => bcrypt('123456'),
    ];
});

$factory->definition(Tests\Models\Profile::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'postcode'   => $faker->postcode,
        'address'    => $faker->address,
        'latitude'   => $faker->latitude,
        'longitude'  => $faker->longitude,
        'color'      => $faker->hexColor,
        'start_at'   => $faker->dateTime,
        'end_at'     => $faker->dateTime,
    ];
});

$factory->definition(Tests\Models\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
