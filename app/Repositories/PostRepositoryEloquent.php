<?php

namespace Juzaweb\Cms\Repositories;

use Juzaweb\Cms;
use Juzaweb\Cms\Repository\Eloquent\BaseRepository;
use Juzaweb\Cms\Models\Post;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Juzaweb\Cms\Repositories;
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
