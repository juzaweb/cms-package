<?php

namespace Juzaweb\Models;

use Juzaweb\Models\Comment;
use Juzaweb\Traits\PostTypeModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 * @property string $slug
 * @property string|null $content
 * @property string $status
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Models\Taxonomy[] $taxonomies
 * @property-read int|null $taxonomies_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublish()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTaxonomy($taxonomy)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTaxonomyIn($taxonomies)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViews($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use PostTypeModel;
    
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'status',
        'views',
        'thumbnail'
    ];

    protected $searchFields = [
        'title',
    ];
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

}
