<?php

namespace Juzaweb\Cms\PostType\Models;

use Juzaweb\Cms\Core\Traits\UseMetaSeo;
use Juzaweb\Cms\Core\Traits\UseSlug;
use Juzaweb\Cms\Core\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Cms\PostType\Models\Page
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereThumbnail($value)
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Page whereMetaTitle($value)
 */
class Page extends Model
{
    use UseThumbnail, UseSlug;
    
    protected $table = 'pages';
    protected $fillable = [
        'name',
        'content',
        'status',
        'thumbnail'
    ];
}
