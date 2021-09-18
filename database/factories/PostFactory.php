<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(\Juzaweb\Models\Post::class, function (Faker $faker) {
    $title = $faker->sentence(10);
    return [
        'title' => $title,
        'content' => $faker->sentence(50),
        'status' => 'publish',
        'slug' => Str::slug($title),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
