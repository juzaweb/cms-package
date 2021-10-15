<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tests\Unit;

use Juzaweb\Tests\TestCase;

class CommandTest extends TestCase
{
    public function testMigration()
    {
        $this->artisan('migrate')
            ->assertExitCode(0);
    }

    public function testSeed()
    {
        $this->artisan('db:seed')
            ->assertExitCode(0);
    }

    public function testOptimize()
    {
        $this->artisan('optimize')
            ->assertExitCode(0);
    }
}
