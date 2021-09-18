<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Juzaweb\Models\Taxonomy;

class TaxonomyController
{
    public function index(...$slug)
    {
        $taxSlug = $slug[1];
        $taxonomy = Taxonomy::where('slug', $taxSlug)
            ->first();

        $title = $taxonomy->name;
        $posts = $taxonomy->posts()
            ->wherePublish()
            ->paginate();

        return view('theme::taxonomy.index', compact(
            'title',
            'taxonomy',
            'posts'
        ));
    }
}
