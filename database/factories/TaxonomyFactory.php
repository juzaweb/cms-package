<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Juzaweb\Models\Taxonomy;

$factory->define(Taxonomy::class, function (Faker $faker) {
    $name = $faker->name;
    $taxonomies = ['categories', 'tags'];
    $taxonomy = $taxonomies[array_rand($taxonomies, 1)];
    $parents = [
        null,
        Taxonomy::where('taxonomy', '=', $taxonomy)
            ->inRandomOrder()
            ->first()->id ?? null
    ];
    $parentId = $parents[array_rand($parents)];

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'taxonomy' => $taxonomy,
        'parent_id' => $parentId,
        'post_type' => 'posts',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
