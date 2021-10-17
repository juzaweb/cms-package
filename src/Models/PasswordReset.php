<?php

namespace Juzaweb\Models;

/**
 * Juzaweb\Models\PasswordReset
 *
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\PasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\PasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\PasswordReset whereToken($value)
 * @mixin \Eloquent
 */
class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $fillable = [
        'email',
        'token'
    ];

    public const UPDATED_AT = null;
}
