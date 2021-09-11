<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Juzaweb\Models\Taxonomy;

class TaxonomyController
{
    public function index()
    {
        return view('pages.taxonomy');
    }

    public function content($slug)
    {
        $tax = Taxonomy::with(['translations'])
            ->where('slug', $slug)
            ->first();
        dd($tax);
    }
}
