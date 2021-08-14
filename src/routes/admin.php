<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 8/12/2021
 * Time: 4:03 PM
 */

use Juzaweb\Blog\Blog;
use Juzaweb\Core\Core;
use Juzaweb\Plugin\Plugin;
use Juzaweb\Theme\Theme;

Blog::adminRoutes();
Core::adminRoutes();
Theme::adminRoutes();
Plugin::adminRoutes();
