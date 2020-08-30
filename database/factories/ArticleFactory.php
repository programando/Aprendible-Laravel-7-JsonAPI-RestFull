<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'slug' => $faker->slug,
        'content' => $faker->paragraphs(3, true),
        'category_id' => factory(\App\Models\Category::class),
        'user_id' => factory(\App\Models\User::class),
    ];
});