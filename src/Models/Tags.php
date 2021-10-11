<?php

namespace Juzaweb\Models;

use Juzaweb\Traits\UseSlug;

/**
 * Juzaweb\Models\Tags
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
