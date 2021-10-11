<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Abstracts;

use Illuminate\View\View;

abstract class Widget
{
    /**
     * Creating widget Backend
     *
     * @param array $data
     * @return View
     */
    abstract public function form($data);

    /**
     * Creating widget front-end
     *
     * @param array $data
     * @return View
     */
    abstract public function show($data);

    /**
     * Updating data block
     *
     * @param array $data
     * @return array
     */
    public function update($data)
    {
        return $data;
    }
}
