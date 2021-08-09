<?php

namespace Juzaweb\Cms\PostType\Repositories;

use Juzaweb\Cms\Repository\Contracts\RepositoryInterface;

/**
 * Interface PostRepository.
 *
 * @package namespace Juzaweb\Cms\Core\Repositories;
 */
interface PostRepository extends RepositoryInterface
{
    public function getSetting();
}
