<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support;

use Illuminate\Cache\CacheManager;
use Juzaweb\Models\Config as ConfigModel;
use Illuminate\Container\Container;

class Config
{
    protected $configs;

    protected $cacheKey = 'jw_configs';

    /**
     * @var CacheManager
     */
    private $cache;

    public function __construct(Container $app)
    {
        $this->cache = $app['cache'];

        $this->configs = $this->cache->rememberForever(
            $this->cacheKey,
            function () {
                return ConfigModel::get([
                    'code',
                    'value',
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
        if (is_array($value) && !empty($value)) {
            $value = array_merge(get_config($key, []), $value);
            $value = json_encode($value);
        }

        $config = ConfigModel::updateOrCreate([
            'code' => $key,
        ], [
            'value' => $value,
        ]);

        $this->configs[$key] = $value;
        $this->cache->forever($this->cacheKey, $this->configs);

        return $config;
    }
}
