<?php

namespace Juzaweb\Cms\PostType\Repositories;

use Juzaweb\Cms\PostType\PostType;
use Juzaweb\Cms\Repository\Eloquent\BaseRepository;
use Juzaweb\Cms\PostType\Models\Taxonomy;

class TaxonomyRepositoryEloquent extends BaseRepository implements TaxonomyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Taxonomy::class;
    }


}
