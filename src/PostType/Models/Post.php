<?php

namespace Juzaweb\Cms\PostType\Models;

use Juzaweb\Cms\Core\Traits\UseSlug;
use Juzaweb\Cms\Core\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Cms\PostType\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 * @property string $slug
 * @property string|null $content
 * @property string|null $category
 * @property string|null $tags
 * @property int $status
 * @property int $views
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Cms\PostType\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\PostType\Models\Post whereViews($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use UseThumbnail, UseSlug;
    
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'status',
        'views',
        'thumbnail'
    ];
    
    public function comments()
    {
        return $this->hasMany('Juzaweb\Cms\PostType\Models\Comment', 'post_id', 'id');
    }

    public function taxonomies()
    {
        return $this->belongsToMany('Juzaweb\Cms\PostType\Models\Taxonomy', 'term_taxonomies', 'term_id', 'taxonomy_id')
            ->withPivot(['term_type'])
            ->wherePivot('term_type', '=', 'posts');
    }
}
