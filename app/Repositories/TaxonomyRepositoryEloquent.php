<?php

namespace Juzaweb\Cms\Repositories;

use Juzaweb\Cms;
use Juzaweb\Cms\Repository\Eloquent\BaseRepository;
use Juzaweb\Cms\Models\Taxonomy;

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
