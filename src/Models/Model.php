<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Juzaweb\Facades\XssCleaner;

/**
 * Juzaweb\Models\Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 * @mixin \Eloquent
 */
class Model extends EloquentModel
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (is_string($value)) {
            return XssCleaner::clean($value);
        }

        return $value;
    }
}