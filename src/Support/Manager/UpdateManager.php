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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Juzaweb\Support\Curl;
use Juzaweb\Support\JuzawebApi;
use Juzaweb\Version;

class UpdateManager
{
    protected $curl;
    protected $api;

    protected $tag;
    protected $val;

    protected $storage;
    protected $response;
    protected $tmpFolder;
    protected $tmpFile;

    public function __construct($tag = 'core', $val = '') {
        $this->curl = app(Curl::class);
        $this->api = app(JuzawebApi::class);

        $this->tag = $tag;
        $this->val = $val;
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
        return Version::getVersion();
    }

    public function getVersionAvailable()
    {
        $uri = $this->tag . '/version-available';

        $response = $this->api->get($uri, [
            'current_version' => $this->getCurrentVersion(),
        ]);

        return $response->version;
    }

    public function updateStep1()
    {
        $uri = $this->tag . '/version-available';

        $response = $this->api->get($uri, [
            'current_version' => $this->getCurrentVersion(),
        ]);

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
            if (!$this->storage->exists($this->tmpFolder . '/' . $folder)) {
                File::makeDirectory($this->storage->path($this->tmpFolder . '/' . $folder), 0775, true);
            }
        }

        $this->tmpFile = $this->tmpFolder . '/zip/' . Str::random(10) . '.zip';
        $this->tmpFile = $this->storage->path($this->tmpFile);

        if (!$this->downloadFile($file, $this->tmpFile)) {
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
        File::moveDirectory($localFolder, $this->storage->path($this->tmpFolder . '/backup'));
        File::moveDirectory($this->storage->path($this->tmpFolder . '/unzip'), $localFolder);
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
                    '--force' => true
                ]);
                break;
            case 'plugin':
                $plugin = app('modules')->find($this->val);
                $plugin->enable();
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
                return plugin_path($this->val);
            case 'theme':
                return theme_path($this->val);
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