<?php

namespace Juzaweb\Cms\PostType\Repositories;

use Juzaweb\Cms\PostType\PostType;
use Juzaweb\Cms\Repository\Eloquent\BaseRepository;
use Juzaweb\Cms\PostType\Models\Post;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Juzaweb\Cms\PostType\Repositories;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    public function getSetting()
    {
        return PostType::getPostTypes('posts');
    }
}
