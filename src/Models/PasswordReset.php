<?php

namespace Juzaweb\Cms\Models;

/**
 * Juzaweb\Cms\Models\PasswordReset
 *
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\PasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\PasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Cms\Models\PasswordReset whereToken($value)
 * @mixin \Eloquent
 */
class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'id';
    protected $fillable = ['email'];
    const UPDATED_AT = null;
}
