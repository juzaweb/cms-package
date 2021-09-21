<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Models;

use Illuminate\Support\Facades\DB;
use Juzaweb\Facades\HookAction;

class Search extends Model
{
    protected $table = 'search';
    protected $fillable = [
        'title',
        'description',
        'keyword',
        'slug',
        'post_id',
        'post_type',
        'status',
    ];

    public function post()
    {
        $model = $this->getPostType('model');
        return $this->belongsTo($model, 'post_id', 'id');
    }

    public function getPostType($key = null)
    {
        $postType = HookAction::getPostTypes($this->post_type);

        if (empty($key)) {
            return $postType;
        }

        return $postType->get($key);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeWherePublish($builder)
    {
        $builder->where('status', '=', 'publish');
        return $builder;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $keyword
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereSearch($builder, $keyword)
    {
        if (DB::getDefaultConnection() == 'mysql') {
//            $builder->addSelect([
//                'match_score' => DB::raw('MATCH (`title`) AGAINST (?) AS match_score', [$keyword]),
//            ]);
            $builder->whereRaw('MATCH (`title`) AGAINST (? IN BOOLEAN MODE)', [$keyword]);
        } else {
            $builder->addSelect(DB::raw('NULL AS match_score'));
            $builder->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%'.$keyword.'%');
                $q->orWhere('description', 'like', '%'.$keyword.'%');
                $q->orWhere('keyword', 'like', '%'.$keyword.'%');
            });
        }

        return $builder;
    }
}
