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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Juzaweb\Facades\HookAction;
use Illuminate\Support\Arr;

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
     * @param Builder $builder
     *
     * @return Builder
     **/
    public function scopeWherePublish($builder)
    {
        $builder->where('status', '=', 'publish');
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeWhereSearch($builder, $params)
    {
        if ($keyword = Arr::get($params, 'q')) {
            $keyword = trim($keyword);
            if (DB::getDefaultConnection() == 'mysql') {
                //$builder->selectRaw(DB::raw('MATCH (`title`) AGAINST (?) AS match_score', [$keyword]));
                $builder->where(function (Builder $q) use ($keyword) {
                    $q->whereRaw('MATCH (`title`) AGAINST (? IN BOOLEAN MODE)', [$keyword]);
                    $q->orWhereRaw('MATCH (`description`) AGAINST (? IN BOOLEAN MODE)', [$keyword]);
                    $q->orWhereRaw('MATCH (`keyword`) AGAINST (? IN BOOLEAN MODE)', [$keyword]);
                });

            } else {
                // $builder->addSelect(DB::raw('NULL AS match_score'));
                $builder->where(function (Builder $q) use ($keyword) {
                    $q->where('title', 'like', '%'.$keyword.'%');
                    $q->orWhere('description', 'like', '%'.$keyword.'%');
                    $q->orWhere('keyword', 'like', '%'.$keyword.'%');
                });
            }
        }

        if ($type = Arr::get($params, 'type')) {
            $builder->where('post_type', '=', $type);
        }

        return $builder;
    }
}
