<?php

namespace Juzaweb\Cms\Laravel;

use Juzaweb\Cms\Abstracts\FileRepository;

class LaravelFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
