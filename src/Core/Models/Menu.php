<?php

namespace Juzaweb\Cms\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Cms\Core\Models\Menu
 *
 * @property int $id
 * @property string $name
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\Menu whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\Menu whereUpdatedAt($value)
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
