<?php namespace Juzaweb\Contracts\Utilities;

use Juzaweb\Entities\Log;
use Illuminate\Contracts\Config\Repository as ConfigContract;

/**
 * Interface  LogMenu
 *
 * @package   Juzaweb\Contracts\Utilities
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface LogMenu
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Set the config instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     *
     * @return self
     */
    public function setConfig(ConfigContract $config);

    /**
     * Set the log styler instance.
     *
     * @param  \Juzaweb\Contracts\Utilities\LogStyler  $styler
     *
     * @return self
     */
    public function setLogStyler(LogStyler $styler);

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Make log menu.
     *
     * @param  \Juzaweb\Entities\Log  $log
     * @param  bool                               $trans
     *
     * @return array
     */
    public function make(Log $log, $trans = true);
}
