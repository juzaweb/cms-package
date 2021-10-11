<?php

namespace Juzaweb\Models;

/**
 * Juzaweb\Models\Languages
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $default
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Languages whereDefault($value)
 */
class Languages extends Model
{
    protected $table = 'languages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'key',
        'name',
        'status',
    ];
}
