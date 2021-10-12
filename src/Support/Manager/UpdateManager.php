<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Manager;

use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Juzaweb\Support\Curl;
use Juzaweb\Support\JuzawebApi;
use Juzaweb\Version;
use Juzaweb\Support\Json;

class UpdateManager
{
    protected $curl;
    /**
     * @var JuzawebApi
     */
    protected $api;

    protected $tag;
    protected $val;
    protected $version;

    protected $storage;
    protected $response;
    protected $tmpFolder;
    protected $tmpFile;

    public function __construct($tag = 'core', $val = '', $version = null)
    {
        $this->curl = app(Curl::class);
        $this->api = app(JuzawebApi::class);

        $this->tag = $tag;
        $this->val = $val;
        $this->version = $version;
        $this->storage = Storage::disk('tmp');
    }

    public function checkUpdate()
    {
        if ($this->getVersionAvailable() > $this->getCurrentVersion()) {
            return true;
        }

        return false;
    }

    public function getCurrentVersion()
    {
        switch ($this->tag) {
            case 'core':
                return Version::getVersion();
            case 'plugin':
                $module = app('modules')->find($this->val);
                if (empty($module)) {
                    return "0";
                }

                return $module->getVersion();
            case 'theme':

        }

        return false;
    }

    public function getVersionAvailable()
    {
        $uri = $this->tag . '/version-available';

        $response = $this->api->get($uri, [
            'plugin' => $this->val,
            'cms_version' => Version::getVersion(),
            'current_version' => $this->getCurrentVersion(),
        ]);

        return str_replace('v', '', $response->version);
    }

    public function update()
    {
        $check = $this->updateStep1();
        if ($check) {
            $this->updateStep2();
            $this->updateStep3();
            $this->updateStep4();
            $this->updateStep5();
        }
    }

    public function updateStep1()
    {
        $uri = $this->tag . '/version-available';

        switch ($this->tag) {
            case 'core':
                $response = $this->api->get($uri, [
                    'current_version' => $this->getCurrentVersion(),
                ]);

                break;
            case 'plugin':
                $response = $this->api->get($uri, [
                    'current_version' => $this->getCurrentVersion(),
                    'plugin' => $this->val,
                    'cms_version' => Version::getVersion(),
                ]);

                break;
            case 'theme':
                break;
        }

        if (empty($response->update)) {
            return false;
        }

        $this->response = $response;

        return true;
    }

    public function updateStep2()
    {
        $file = $this->response->link;

        $this->tmpFolder = $this->tag . '/' . Str::random(5);
        foreach (['zip', 'unzip', 'backup'] as $folder) {
            if (! $this->storage->exists($this->tmpFolder . '/' . $folder)) {
                File::makeDirectory($this->storage->path($this->tmpFolder . '/' . $folder), 0775, true);
            }
        }

        $this->tmpFile = $this->tmpFolder . '/zip/' . Str::random(10) . '.zip';
        $this->tmpFile = $this->storage->path($this->tmpFile);

        if (! $this->downloadFile($file, $this->tmpFile)) {
            return false;
        }

        return true;
    }

    public function updateStep3()
    {
        $zip = new \ZipArchive();
        $op = $zip->open($this->tmpFile);

        if ($op !== true) {
            return false;
        }

        $zip->extractTo($this->storage->path($this->tmpFolder . '/unzip'));
        $zip->close();

        return true;
    }

    public function updateStep4()
    {
        $localFolder = $this->getLocalFolder();
        $zipFolders = File::directories($this->storage->path($this->tmpFolder . '/unzip'));
        File::moveDirectory($localFolder, $this->storage->path($this->tmpFolder . '/backup'));
        foreach ($zipFolders as $folder) {
            File::moveDirectory($folder, $localFolder);

            break;
        }

        File::deleteDirectory($this->storage->path($this->tmpFolder), true);
        File::deleteDirectory($this->storage->path($this->tmpFolder), true);
    }

    public function updateStep5()
    {
        switch ($this->tag) {
            case 'core':
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('vendor:publish', [
                    '--tag' => 'juzaweb_assets',
                    '--force' => true,
                ]);

                /**
                 * @var \Juzaweb\Abstracts\Plugin[] $plugins
                 */
                $plugins = app('modules')->all();
                foreach ($plugins as $plugin) {
                    if (! $plugin->isEnabled()) {
                        continue;
                    }

                    $plugin->disable();
                    $plugin->enable();
                }

                break;
            case 'plugin':
                /**
                 * @var \Juzaweb\Abstracts\Plugin $plugin
                 */
                $plugin = app('modules')->find($this->val);
                if ($plugin->isEnabled()) {
                    $plugin->disable();
                    $plugin->enable();
                }

                break;
            case 'theme':
                if ($this->val == jw_current_theme()) {
                    Artisan::call('theme:publish', [
                        'theme' => $this->val,
                        'type' => 'assets',
                    ]);
                }
        }
    }

    protected function getLocalFolder()
    {
        switch ($this->tag) {
            case 'core':
                return base_path('vendor/juzaweb/cms');
            case 'plugin':
                return config('juzaweb.plugin.path') . '/' . $this->val;
            case 'theme':
                return config('juzaweb.theme.path') . '/' . $this->val;
        }

        return false;
    }

    protected function downloadFile($url, $filename)
    {
        $resource = Utils::tryFopen($filename, 'w');

        try {
            $this->curl->getClient()->request('GET', $url, [
                'curl' => [
                    CURLOPT_TCP_KEEPALIVE => 10,
                    CURLOPT_TCP_KEEPIDLE => 10,
                ],
                'sink' => $resource,
            ]);

            return $filename;
        } catch (\Throwable $e) {
            Log::error($e);
        }

        return false;
    }
}
