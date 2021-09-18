<?php

use Illuminate\Database\Seeder;
use Juzaweb\Models\Taxonomy;

class PostTableSeeder extends Seeder
{
    public function run()
    {
        factory(\Juzaweb\Models\Post::class, 10)->create()->each(function ($item) {
            $categories = Taxonomy::where('taxonomy', '=', 'categories')
                ->where('post_type', '=', 'posts')
                ->inRandomOrder()
                ->limit(3);

            $tags = Taxonomy::where('taxonomy', '=', 'tags')
                ->where('post_type', '=', 'posts')
                ->inRandomOrder()
                ->limit(5);

            $item->syncTaxonomy('categories', [
                'categories' => $categories->pluck('id')->toArray()
            ], 'posts');

            $item->syncTaxonomy('tags', [
                'tags' => $tags->pluck('id')->toArray()
            ], 'posts');
        });
    }
}
