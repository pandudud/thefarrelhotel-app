<?php

$factory->define(TheFarrelHotel\Http\Models\Kamar\Room::class, function (Faker\Generator $faker) {
    return [
        'room_name' => $faker->company,
        'room_name_eng' => $faker->company,
        'room_name_slug' => str_slug($faker->company),
        'room_price' => $faker->numberBetween(500000, 1000000),
        'room_description' => $faker->text(150),
        'room_description_eng' => $faker->text(200),
        'created_at' => $faker->date('Y-m-d', 'now')
    ];
});
