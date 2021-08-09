<?php

namespace Juzaweb\Cms\Core\Models;

use Juzaweb\Cms\Core\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Cms\Core\Models\Tags
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Tags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tags query()
 * @mixin \Eloquent
 */
class Tags extends Model
{
    use UseSlug;
    
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
}
