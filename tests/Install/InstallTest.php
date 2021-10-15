<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tests\Install;

use Illuminate\Support\Facades\DB;
use Juzaweb\Support\Installer;
use Juzaweb\Tests\TestCase;

class InstallTest extends TestCase
{
    public function testInstallCommand()
    {
        $this->resetTestData();

        $this->artisan('juzaweb:install')
            ->expectsQuestion('Full Name?', 'Taylor Otwell')
            ->expectsQuestion('Email?', 'demo@gmail.com')
            ->expectsQuestion('Password?', '12345678')
            ->assertExitCode(0);

        $this->assertTrue(file_exists(Installer::installedPath()));
    }

    public function testInstallWeb()
    {
        $this->resetTestData();

        $response = $this->post('install/environment', [
            '_token' => csrf_token(),
            'database_connection' => env('DB_CONNECTION'),
            'database_hostname' => env('DB_HOST'),
            'database_port' => env('DB_PORT'),
            'database_name' => env('DB_DATABASE'),
            'database_username' => env('DB_USERNAME'),
            'database_password' => env('DB_PASSWORD'),
            'database_prefix' => env('DB_PREFIX'),
        ]);

        $response->assertSessionDoesntHaveErrors();

        $response = $this->get('install/database');
        $this->assertEquals(302, $response->getStatusCode());

        $response = $this->get('install/admin');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->post('install/admin', [
            '_token' => csrf_token(),
            'name' => 'Taylor Otwell',
            'email' => 'demo@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertSessionDoesntHaveErrors();

        $response = $this->get('install/final');
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertTrue(DB::table('users')
            ->where('is_admin', '=', 1)
            ->exists());

        $this->assertTrue(file_exists(Installer::installedPath()));
    }

    protected function resetTestData()
    {
        $this->artisan('migrate:reset')
            ->assertExitCode(0);

        if (file_exists(Installer::installedPath())) {
            unlink(Installer::installedPath());
        }
    }
}
