<?php

namespace Juzaweb\Database\Factories;

use Illuminate\Support\Str;
use Juzaweb\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(10);

        return [
            'title' => $title,
            'content' => $this->faker->sentence(500),
            'status' => 'publish',
            'slug' => Str::slug($title),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
