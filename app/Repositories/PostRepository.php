<?php

namespace Juzaweb\Cms\Repositories;

use Juzaweb\Cms\Repository\Contracts\RepositoryInterface;

/**
 * Interface PostRepository.
 *
 * @package namespace Juzaweb\Cms\Repositories;
 */
interface PostRepository extends RepositoryInterface
{
    public function getSetting();
}
