<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits;

use Illuminate\Support\Str;

trait UseDescription
{
    public static function bootUseDescription()
    {
        static::saving(function ($model) {
            $model->description = str_words_length(
                strip_tags($model->content),
                55,
                320
            );
        });
    }

    public function getDescription($words = 24)
    {
        return apply_filters(
            $this->getPostType('key') . '.get_description',
            Str::words($this->description, $words),
            $words
        );
    }
}
