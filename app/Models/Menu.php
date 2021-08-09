<?php

namespace Juzaweb\Cms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Cms\Models\Menu
 *
 * @property int $id
 * @property string $name
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\Menu whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\Menu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'content',
    ];
}
