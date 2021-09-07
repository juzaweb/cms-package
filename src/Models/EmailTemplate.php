<?php

namespace Juzaweb\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Juzaweb\Cms\Traits\ResourceModel;

/**
 * Juzaweb\Cms\Models\EmailTemplate
 *
 * @property int $id
 * @property string $code
 * @property string $subject
 * @property string $body
 * @property array|null $params
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $layout
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereLayout($value)
 */
class EmailTemplate extends Model
{
    use ResourceModel;

    protected $fieldName = 'subject';
    protected $table = 'email_templates';
    protected $fillable = [
        'code',
        'subject',
        'body',
        'params'
    ];
    
    protected $casts = [
        'params' => 'array'
    ];
}
