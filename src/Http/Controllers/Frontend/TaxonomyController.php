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
        $postType = $taxonomy->getPostType('model');
        $posts = $postType::selectFrontendBuilder()
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
