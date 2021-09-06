<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Support\Theme;

use Illuminate\Support\Facades\Cache;
use Juzaweb\Cms\Models\ThemeConfig as ConfigModel;

class ThemeConfig
{
    protected $configs;
    protected $theme;
    protected $cacheKey = 'jw_theme_configs';

    public function __construct($theme)
    {
        $this->theme = $theme;
        $this->configs = Cache::rememberForever($this->cacheKey, function () {
            return ConfigModel::where('theme', '=', $this->theme)
                ->get([
                    'code',
                    'value'
                ])->keyBy('code')
                ->map(function ($item) {
                    return $item->value;
                })
                ->toArray();
        });
    }

    public function getConfig($key, $default = null)
    {
        $value = $this->configs[$key] ?? $default;
        if (is_json($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    public function setConfig($key, $value = null)
    {
        if (is_array($value)) {
            $value = array_merge(get_config($key, []), $value);
            $value = json_encode($value);
        }

        $config = ConfigModel::updateOrCreate([
            'code' => $key,
            'theme' => $this->theme
        ], [
            'value' => $value
        ]);

        $this->configs[$key] = $value;
        Cache::forever($this->cacheKey, $this->configs);

        return $config;
    }
}