<?php

namespace Juzaweb\Cms\Updater\Events;

use Juzaweb\Cms\Updater\Models\Release;

class UpdateFailed
{
    protected $release;

    public function __construct(Release $release)
    {
        $this->release = $release;
    }
}
