<?php

$factory->define(App\Data\Models\Article::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->title,
        'content' => $faker->realText,
        'user_id' => function () {
            return factory(App\Data\Models\User::class)->create()->id;
        },
    ];
});
