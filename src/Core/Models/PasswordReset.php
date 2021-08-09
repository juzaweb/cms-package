<?php

namespace Juzaweb\Cms\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Cms\Core\Models\PasswordReset
 *
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\PasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\PasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Core\Models\PasswordReset whereToken($value)
 * @mixin \Eloquent
 */
class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'id';
    protected $fillable = ['email'];
    const UPDATED_AT = null;
}
