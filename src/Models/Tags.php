<?php

namespace Juzaweb\Cms\Models;

use Juzaweb\Cms\Support\Traits\UseSlug;

/**
 * Juzaweb\Cms\Models\Tags
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
