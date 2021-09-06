<?php

namespace Juzaweb\Cms\Support;

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
