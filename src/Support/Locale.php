<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Support;

use Illuminate\Support\Collection;
use Juzaweb\Cms\Facades\Plugin;
use Juzaweb\Theme\Facades\Theme;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class Locale
{
    public function all()
    {
        $result = [];
        $result['core'] = collect([
            'title' => 'Core Juzaweb',
            'key' => 'core',
            'type' => 'core',
            'path' => 'vendor/juzaweb/core/src/resources/lang',
            'publish_path' => 'lang/vendor/juzaweb',
        ]);

        $result = array_merge($result, $this->getLocalePlugins());
        $result = array_merge($result, $this->getLocaleThemes());

        return collect($result);
    }

    public function getLocalePlugins()
    {
        $result = [];
        $plugins = Plugin::all();
        foreach ($plugins as $plugin) {
            $snakeName = namespace_snakename($plugin->get('name'));
            $result[$snakeName] = collect([
                'title' => $plugin->getDisplayName(),
                'key' => $snakeName,
                'type' => 'plugin',
                'path' => 'plugins/' . $plugin->get('name') . '/src/resources/lang',
                'publish_path' => 'lang/vendor/' . $snakeName,
            ]);
        }

        return $result;
    }

    public function getLocaleThemes()
    {
        $result = [];
        $themes = Theme::all();
        foreach ($themes as $theme) {
            $result['theme_' . $theme->get('name')] = collect([
                'title' => $theme->get('title'),
                'key' => 'theme_' . $theme->get('name'),
                'type' => 'theme',
                'path' => 'themes/' . $theme->get('name') . '/lang',
                'publish_path' => 'lang/vendor/theme_' . $theme->get('name'),
            ]);
        }

        return $result;
    }

    public function getByKey(string $key)
    {
        return $this->all()->get($key, []);
    }

    /**
     * Get all language trans
     *
     * @param Collection|string $key
     * @param string $locale
     * @return array
     */
    public function getAllTrans($key, $locale)
    {
        $key = $this->parseVar($key);
        /**
         * @var SplFileInfo[] $files
         */
        $files = File::files($this->originPath($key, 'en'));
        $files = collect($files)->filter(function (SplFileInfo $item) {
            return $item->getExtension() == 'php';
        })->values()->toArray();

        $result = [];
        foreach ($files as $file) {
            $trans = [];
            $lang = require ($file->getRealPath());
            $langPublish = $this->publishPath($key, $locale . '/' . $file->getFilename());

            if (file_exists($langPublish)) {
                $langPublish = require ($langPublish);
                foreach ($langPublish as $langKey => $langVal) {
                    $trans[$langKey] = $langVal;
                }
            }

            $group = str_replace('.php', '', $file->getFilename());
            $this->mapGroupKeys($lang, $group, $trans, $result);
        }

        return $result;
    }

    /**
     * Get all language from data plugin/theme/core
     *
     * @param Collection|string $key
     * @return array
     */
    public function allLanguageOrigin($key)
    {
        $folderPath = $this->originPath($key);

        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = File::directories($folderPath);
        $folders = collect($folders)->map(function ($item) {
            return basename($item);
        })->values()->toArray();

        return collect(config('locales'))
            ->whereIn('code', $folders)
            ->toArray();
    }

    /**
     * Get all language publish from data plugin/theme/core
     *
     * @param Collection|string $key
     * @return array
     */
    public function allLanguagePublish($key)
    {
        $folderPath = $this->publishPath($key);

        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = File::directories($folderPath);
        $folders = collect($folders)->map(function ($item) {
            return basename($item);
        })->values()->toArray();

        return collect(config('locales'))
            ->whereIn('code', $folders)
            ->toArray();
    }

    /**
     * Get all language publish and origin
     *
     * @param Collection|string $key
     * @return array
     */
    public function allLanguage($key)
    {
        return array_merge($this->allLanguageOrigin($key), $this->allLanguagePublish($key));
    }

    public function originPath($key, $path = '')
    {
        $key = $this->parseVar($key);
        $basePath = base_path($key->get('path'));

        if (empty($path)) {
            return $basePath;
        }

        return $basePath . '/' . $path;
    }

    public function publishPath($key, $path = '')
    {
        $key = $this->parseVar($key);
        $basePath = resource_path($key->get('publish_path'));

        if (empty($path)) {
            return $basePath;
        }

        return $basePath . '/' . $path;
    }

    /**
     * @param Collection|string $key
     * @return Collection
     */
    protected function parseVar($key)
    {
        if (is_a($key, Collection::class)) {
            return $key;
        }

        return $this->getByKey($key);
    }

    protected function mapGroupKeys(array $lang, $group, $trans, &$result)
    {
        foreach ($lang as $key => $item) {
            if (is_array($item)) {
                $this->mapGroupKeys($item, $group .'.'. $key, $trans, $result);
            } else {
                $result[] = [
                    'key' => $group .'.'. $key,
                    'value' => $item,
                    'trans' => $trans[$key] ?? $item
                ];
            }
        }
    }
}
