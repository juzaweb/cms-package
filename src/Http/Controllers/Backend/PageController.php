<?php

namespace Juzaweb\Http\Controllers\Backend;

use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Models\Page;
use Juzaweb\Traits\PostTypeController;

class PageController extends BackendController
{
    use PostTypeController;

    protected $viewPrefix = 'juzaweb::backend.page';

    /**
     * @return string
     */
    protected function getModel()
    {
        return Page::class;
    }
}
