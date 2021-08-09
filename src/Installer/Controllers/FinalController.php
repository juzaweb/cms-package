<?php

namespace Juzaweb\Cms\Installer\Controllers;

use Illuminate\Routing\Controller;
use Juzaweb\Cms\Installer\Events\LaravelInstallerFinished;
use Juzaweb\Cms\Installer\Helpers\EnvironmentManager;
use Juzaweb\Cms\Installer\Helpers\FinalInstallManager;
use Juzaweb\Cms\Installer\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Juzaweb\Cms\Installer\Helpers\InstalledFileManager $fileManager
     * @param \Juzaweb\Cms\Installer\Helpers\FinalInstallManager $finalInstall
     * @param \Juzaweb\Cms\Installer\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish (
        InstalledFileManager $fileManager,
        FinalInstallManager $finalInstall,
        EnvironmentManager $environment
    )
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();

        event(new LaravelInstallerFinished);

        return view('installer::finished', compact(
            'finalMessages',
            'finalStatusMessage'
        ));
    }
}
