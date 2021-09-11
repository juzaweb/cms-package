<?php

namespace Juzaweb\Http\Controllers\Backend;

use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Traits\PostTypeController;
use Juzaweb\Models\Post;

class PostController extends BackendController
{
    use PostTypeController;

    protected function getModel()
    {
        return Post::class;
    }
}
