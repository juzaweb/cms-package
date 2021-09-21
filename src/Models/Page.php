<?php

namespace Juzaweb\Models;

use Juzaweb\Traits\PostTypeModel;

/**
 * Juzaweb\Models\Page
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Models\Taxonomy[] $taxonomies
 * @property-read int|null $taxonomies_count
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePublish()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTaxonomy($taxonomy)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTaxonomyIn($taxonomies)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTemplateData($value)
 * @property string $title
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Juzaweb\Models\User|null $createdBy
 * @property-read \Juzaweb\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedBy($value)
 */
class Page extends Model
{
    use PostTypeModel;
    
    protected $table = 'pages';
    protected $postType = 'pages';

    protected $fillable = [
        'title',
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


}
