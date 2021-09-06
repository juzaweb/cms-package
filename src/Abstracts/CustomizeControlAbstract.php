<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Abstracts;

use Illuminate\Support\Collection;
use Juzaweb\Cms\Support\Customize;

abstract class CustomizeControlAbstract
{
    /**
     * @var Customize $customize
     */
    protected $customize;

    protected $key;

    /**
     * @var Collection $args
     */
    protected $args;

    public function __construct(Customize $customize, $key, $args = [])
    {
        $this->customize = $customize;
        $this->key = $key;
        $this->args = new Collection($args);
    }

    abstract public function contentTemplate();

    public function getKey()
    {
        return $this->key;
    }

    public function getArgs()
    {
        return $this->args;
    }
}