<?php

namespace Juzaweb\Models;

use Juzaweb\Models\Model;

/**
 * Juzaweb\Models\ThemeConfig
 *
 * @property int $id
 * @property string $code
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\ThemeConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\ThemeConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\ThemeConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\ThemeConfig whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\ThemeConfig whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\ThemeConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\ThemeConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\ThemeConfig whereUpdatedAt($value)
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
