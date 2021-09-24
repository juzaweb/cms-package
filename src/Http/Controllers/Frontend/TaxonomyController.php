<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Illuminate\Support\Str;
use Juzaweb\Models\Taxonomy;

class TaxonomyController
{
    public function index(...$slug)
    {
        $taxSlug = $slug[1];
        $taxonomy = Taxonomy::where('slug', $taxSlug)
            ->firstOrFail();

        $title = $taxonomy->getName();
        $posts = $taxonomy->posts()
            ->wherePublish()
            ->paginate();

        $template = get_name_template_part(
            Str::singular($taxonomy->post_type),
            'taxonomy'
        );

        return view('theme::template-parts.' . $template, compact(
            'title',
            'taxonomy',
            'posts',
            'template'
        ));
    }
}
