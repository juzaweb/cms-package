<?php

namespace Juzaweb\Cms\Models;

use Juzaweb\Cms\Traits\PostTypeModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Cms\Models\Page
 *
 * @property int $id
 * @property string $name
 * @property string|null $thumbnail
 * @property string $slug
 * @property string|null $content
 * @property string $status
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereViews($value)
 * @mixin \Eloquent
 * @property string|null $template
 * @property array|null $template_data
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Cms\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Cms\Models\Taxonomy[] $taxonomies
 * @property-read int|null $taxonomies_count
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePublish()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTaxonomy($taxonomy)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTaxonomyIn($taxonomies)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTemplateData($value)
 */
class Page extends Model
{
    use PostTypeModel;
    
    protected $table = 'pages';
    protected $fillable = [
        'name',
        'content',
        'status',
        'thumbnail',
        'template',
        'template_data',
        'views',
    ];

    protected $casts = [
        'template_data' => 'array',
    ];

    public static function findBySlugOrFail($slug)
    {
        return self::query()
            ->where('slug', '=', $slug)
            ->firstOrFail();
    }
}
