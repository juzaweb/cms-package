<?php

namespace Juzaweb\Models;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Facades\HookAction;

/**
 * Juzaweb\Models\Comment
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $email
 * @property string|null $name
 * @property string|null $website
 * @property string $content
 * @property int $object_id Post type ID
 * @property string $object_type Post type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereContent($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereEmail($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereName($value)
 * @method static Builder|Comment whereObjectId($value)
 * @method static Builder|Comment whereObjectType($value)
 * @method static Builder|Comment whereStatus($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUserId($value)
 * @method static Builder|Comment whereWebsite($value)
 * @mixin \Eloquent
 * @method static Builder|Comment whereApproved()
 */
class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'email',
        'name',
        'website',
        'content',
        'status',
        'object_type',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function postType()
    {
        $postType = HookAction::getPostTypes($this->object_type);

        return $postType->get('model')::find($this->object_id);
    }

    public function scopeWhereApproved(Builder $builder)
    {
        return $builder->where('status', '=', 'approved');
    }

    public function getUserName()
    {
        return $this->user ? $this->user->name : $this->name;
    }

    public function getAvatar()
    {
        if ($this->user) {
            return $this->user->getAvatar();
        }

        return asset('jw-styles/juzaweb/styles/images/avatar.png');
    }

    public function getUpdatedDate($format = JW_DATE_TIME)
    {
        return jw_date_format($this->updated_at, $format);
    }

    public function getCreatedDate($format = JW_DATE_TIME)
    {
        return jw_date_format($this->updated_at, $format);
    }

    public static function allStatuses()
    {
        return apply_filters('comment.statuses', [
            'approved' => trans('juzaweb::app.approved'),
            'deny' => trans('juzaweb::app.deny'),
            'pending' => trans('juzaweb::app.pending'),
            'trash' => trans('juzaweb::app.trash'),
        ]);
    }
}
