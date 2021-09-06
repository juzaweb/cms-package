<?php

namespace Juzaweb\Theme\Models;

use Juzaweb\Cms\Models\Model;

/**
 * Juzaweb\Theme\Models\ThemeConfig
 *
 * @property int $id
 * @property string $code
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Theme\Models\ThemeConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Theme\Models\ThemeConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Theme\Models\ThemeConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Theme\Models\ThemeConfig whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Theme\Models\ThemeConfig whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Theme\Models\ThemeConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Theme\Models\ThemeConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Theme\Models\ThemeConfig whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ThemeConfig extends Model
{
    protected $table = 'theme_configs';
    protected $fillable = [
        'code',
        'theme',
        'value',
    ];
}
