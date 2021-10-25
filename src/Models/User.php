<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 7/10/2021
 * Time: 3:13 PM
 */

namespace Juzaweb\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Juzaweb\Traits\ResourceModel;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Juzaweb\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $avatar
 * @property int $is_admin
 * @property string $status unconfimred, banned, active
 * @property string $language
 * @property string|null $verification_token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User active()
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereLanguage($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereVerificationToken($value)
 * @mixin \Eloquent
 * @method static Builder|User whereFilter($params = [])
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use ResourceModel;

    const STATUS_ACTIVE = 'active';
    const STATUS_VERIFICATION = 'verification';
    const STATUS_BANNED = 'banned';

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'status',
        'verification_token',
        'password',
        'data',
    ];

    public $casts = [
        'data' => 'array'
    ];

    public static function getAllStatus()
    {
        return [
            'active' => trans('juzaweb::app.active'),
            'unconfirmed' => trans('juzaweb::app.unconfimred'),
            'banned' => trans('juzaweb::app.banned'),
            'verification' => trans('juzaweb::app.verification'),
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * */
    public function scopeActive($builder)
    {
        return $builder->where('status', '=', 'active');
    }

    public function getAvatar()
    {
        if ($this->avatar) {
            return upload_url($this->avatar);
        }

        return asset('jw-styles/juzaweb/styles/images/avatar.png');
    }
}
