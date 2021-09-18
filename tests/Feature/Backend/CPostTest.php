<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Tests\Feature\Backend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Facades\HookAction;
use Juzaweb\Models\Model;
use Juzaweb\Models\User;
use Juzaweb\Tests\TestCase;

class CPostTest extends TestCase
{
    protected $user;

    protected $postTypes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::where('is_admin', '=', 1)
            ->first();

        Auth::loginUsingId($this->user->id);

        $this->postTypes = HookAction::getPostTypes();
    }

    public function testPostTypes()
    {
        foreach ($this->postTypes as $key => $postType) {
            $this->indexTest($key);

            $this->createTest($key, $postType);

            $this->updateTest($postType);
        }
    }

    protected function indexTest($key)
    {
        $response = $this->get('/admin-cp/' . $key);

        $response->assertStatus(200);
    }

    protected function createTest($key, $postType)
    {
        $response = $this->get('/admin-cp/'. $key .'/create');

        $response->assertStatus(200);

        if ($post = $this->makeFactory($postType)) {
            $old = app($postType->get('model'))->count();
            $this->post('/admin-cp/posts', $post->getAttributes());
            $new = app($postType->get('model'))->count();
            $this->assertEquals($old, ($new - 1));
        }
    }

    protected function updateTest($postType)
    {
        if ($post = $this->makeFactory($postType)) {
            $model = app($postType->get('model'))->first(['id']);
            $response = $this->get('/admin-cp/posts/' . '/' . $model->id . '/edit');

            $response->assertStatus(200);

            $this->put('/admin-cp/posts/' . $model->id, $post->getAttributes());

            $model = app($postType->get('model'))
                ->where('id', '=', $model->id)
                ->first();

            $this->assertEquals($post->getAttribute('title'), $model->title);
        }
    }

    /**
     *
     * @param Collection $postType
     *
     * @return Model|false
     */
    protected function makeFactory($postType)
    {
        try {
            $post = factory($postType->get('model'))->make();

            return $post;
        } catch (\Throwable $e) {
            echo "\n--- " . $e->getMessage();
        }

        return false;
    }
}
