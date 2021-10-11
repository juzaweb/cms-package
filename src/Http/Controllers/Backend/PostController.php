<?php

namespace Juzaweb\Http\Controllers\Backend;

use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Models\Post;
use Juzaweb\Traits\PostTypeController;

class PostController extends BackendController
{
    use PostTypeController;

    protected function getModel()
    {
        return Post::class;
    }
}
