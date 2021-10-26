<?php

namespace Juzaweb\Support\Theme;

use Composer\Autoload\ClassLoader;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\View\ViewFinderInterface;
use Juzaweb\Abstracts\Action;
use Juzaweb\Contracts\ThemeContract;
use Juzaweb\Exceptions\ThemeNotFoundException;
use Juzaweb\Facades\HookAction;
use Noodlehaus\Config;

class Theme implements ThemeContract
{
    /**
     * Theme Root Path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Blade View Finder.
     *
     * @var \Illuminate\View\ViewFinderInterface
     */
    protected $finder;

    /**
     * Application Container.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    /**
     * Translator.
     *
     * @var \Illuminate\Translation\Translator
     */
    protected $lang;

    /**
     * Config.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Current Active Theme.
     *
     * @var string
     */
    private $activeTheme = null;

    /**
     * Theme constructor.
     *
     * @param Container           $app
     * @param ViewFinderInterface $finder
     * @param Repository          $config
     * @param Translator          $lang
     */
    public function __construct(
        Container $app,
        ViewFinderInterface $finder,
        Repository $config,
        Translator $lang
    ) {
        $this->config = $config;
        $this->app = $app;
        $this->finder = $finder;
        $this->lang = $lang;
        $this->basePath = config('juzaweb.theme.path');
    }

    /**
     * Set current theme.
     *
     * @param string $theme
     *
     * @return void
     */
    public function set($theme)
    {
        if (! $this->has($theme)) {
            throw new ThemeNotFoundException($theme);
        }

        $this->loadTheme($theme);
        $this->activeTheme = $theme;
    }

    /**
     * Check if theme exists.
     *
     * @param string $theme
     *
     * @return bool
     */
    public function has($theme)
    {
        $themeConfigPath = $this->getThemePath($theme) . '/theme.json';

        return file_exists($themeConfigPath);
    }

    public function getThemePath($theme, $path = '')
    {
        $result = $this->basePath . '/' . $theme;

        if (empty($path)) {
            return $result;
        }

        return $result . '/' . $path;
    }

    /**
     * Get particular theme all information.
     *
     * @param string $theme
     *
     * @return null|Config
     */
    public function getThemeInfo($theme)
    {
        $themePath = $this->getThemePath($theme);
        $themeConfigPath = $themePath . '/theme.json';
        $themeChangelogPath = $themePath . '/changelog.yml';

        if (file_exists($themeConfigPath)) {
            $themeConfig = Config::load($themeConfigPath);
            $themeConfig['changelog'] = Config::load($themeChangelogPath)->all();
            $themeConfig['path'] = $themePath;

            if ($themeConfig->has('name')) {
                return $themeConfig;
            }
        }

        return null;
    }

    /**
     * Returns current theme or particular theme information.
     *
     * @param string $theme
     * @param bool   $collection
     *
     * @return array|null
     */
    public function get($theme = null, $collection = false)
    {
        if (is_null($theme) || ! $this->has($theme)) {
            if ($collection) {
                return $this->getThemeInfo($this->activeTheme)->all();
            }

            return $this->getThemeInfo($this->activeTheme)->all();
        }

        if ($collection) {
            return $this->getThemeInfo($theme)->all();
        }

        return $this->getThemeInfo($theme)->all();
    }

    /**
     * Get current active theme name only or themeinfo collection.
     *
     * @param bool $collection
     *
     * @return null
     */
    public function current($collection = false)
    {
        return ! $collection ? $this->activeTheme : $this->getThemeInfo($this->activeTheme);
    }

    /**
     * Get all theme information.
     *
     * @return array
     */
    public function all()
    {
        $themeDirectories = File::directories($this->basePath);
        $themes = [];
        foreach ($themeDirectories as $theme) {
            $themeConfig = $this->getThemeInfo(basename($theme));
            if (empty($themeConfig)) {
                continue;
            }

            $themes[$themeConfig->get('name')] = $themeConfig;
        }

        return $themes;
    }

    public function publicPath($theme)
    {
        return public_path('jw-styles/themes/' . $theme);
    }

    public function assetsUrl($theme, $secure = null)
    {
        return asset('jw-styles/themes/' . $theme . '/assets', $secure);
    }

    /**
     * Find asset file for theme asset.
     *
     * @param string $path
     * @param string $theme
     * @param null|bool $secure
     *
     * @return string
     */
    public function assets($path, $theme = null, $secure = null)
    {
        if (empty($theme)) {
            $theme = $this->activeTheme;
        }

        return $this->assetsUrl($theme, $secure) . '/' . $path;
    }

    /**
     * Find theme asset from theme directory.
     *
     * @param string $path
     * @param string $theme
     *
     * @return string|false
     */
    public function getFullPath($path, $theme = null)
    {
        $splitThemeAndPath = explode(':', $path);

        if (count($splitThemeAndPath) > 1) {
            if (is_null($splitThemeAndPath[0])) {
                return false;
            }
            $themeName = $splitThemeAndPath[0];
            $path = $splitThemeAndPath[1];
        } else {
            $themeName = $this->activeTheme;
            $path = $splitThemeAndPath[0];
        }

        $themeInfo = $this->getThemeInfo($themeName);
        $themePath = str_replace(base_path('public') . DIRECTORY_SEPARATOR, '', $themeInfo->get('path')) . DIRECTORY_SEPARATOR;

        $assetPath = $this->config['theme.folders.assets'] . DIRECTORY_SEPARATOR;
        $fullPath = $themePath . $assetPath . $path;

        if (! file_exists($fullPath) && $themeInfo->has('parent') && ! empty($themeInfo->get('parent'))) {
            $themePath = str_replace(base_path().DIRECTORY_SEPARATOR, '', $this->getThemeInfo($themeInfo->get('parent'))->get('path')).DIRECTORY_SEPARATOR;
            $fullPath = $themePath . $assetPath . $path;

            return $fullPath;
        }

        return $fullPath;
    }

    /**
     * Get the current theme path to a versioned Mix file.
     *
     * @param string $path
     * @param string $manifestDirectory
     *
     * @return \Illuminate\Support\HtmlString|string
     * @throws \Exception
     */
    public function themeMix($path, $manifestDirectory = '')
    {
        return mix($this->getFullPath($path), $manifestDirectory);
    }

    public function getScreenshot($theme)
    {
        $path = $this->getThemePath($theme, 'assets/screenshot.png');
        if (file_exists($path)) {
            return theme_assets('screenshot.png', $theme);
        }

        return asset('jw-styles/juzaweb/images/screenshot.svg');
    }

    public function getVersion($theme)
    {
        $info = $this->getThemeInfo($theme);
        return $info->get('version', 0);
    }

    /**
     * Map view map for particular theme.
     *
     * @param string $theme
     *
     * @return void
     */
    protected function loadTheme($theme)
    {
        if (is_null($theme)) {
            return;
        }

        $themeInfo = $this->getThemeInfo($theme);
        if (is_null($themeInfo)) {
            return;
        }

        $hasParent = false;
        if ($parent = $themeInfo->get('parent')) {
            $this->loadTheme($parent);
            $hasParent = true;
        }

        $loader = new ClassLoader(
            config('juzaweb.plugin.path')
        );

        if (is_dir($themeInfo->get('path') . '/src')) {
            $loader->setPsr4('Theme\\', [$themeInfo->get('path') . '/src']);
        }

        $loader->register(true);

        $viewPath = $themeInfo->get('path') . '/views';
        $langPath = $themeInfo->get('path') .'/lang';

        $viewPublishPath = resource_path('views/vendor/theme_' . $theme);
        $langPublishPath = resource_path('lang/vendor/theme_' . $theme);

        $styles = $themeInfo->get('styles', []);
        $templates = $themeInfo->get('templates', []);

        if ($styles) {
            add_action(Action::FRONTEND_CALL_ACTION, function () use ($styles) {
                foreach ($styles['js'] ?? [] as $index => $js) {
                    HookAction::enqueueFrontendScript('main-' . $index, $js);
                }

                foreach ($styles['css'] ?? [] as $index => $css) {
                    HookAction::enqueueFrontendStyle('main' . $index, $css);
                }
            });
        }

        if ($hasParent) {
            $this->finder->prependNamespace('theme', $viewPath);
        } else {
            $this->finder->addNamespace('theme', $viewPath);
        }

        if (is_dir($viewPublishPath)) {
            $this->finder->addNamespace('theme', $viewPath);
        }

        $this->lang->addNamespace('theme', $langPath);

        if (is_dir($langPublishPath)) {
            $this->lang->addNamespace('theme', $langPublishPath);
        }

        if ($templates) {
            add_action(Action::JUZAWEB_INIT_ACTION, function () use ($templates) {
                foreach ($templates as $key => $template) {
                    HookAction::registerThemeTemplate($key, [
                        'name' => Arr::get($template, 'name'),
                        'view' => Arr::get($template, 'view')
                    ]);
                }
            });
        }
    }
}
