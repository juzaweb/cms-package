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

            $this->updateTest($key, $postType);
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

        if ($post = $this->makerData($postType)) {
            $old = app($postType->get('model'))->count();
            $this->post('/admin-cp/' . $key, $post);
            $new = app($postType->get('model'))->count();
            $this->assertEquals($old, ($new - 1));
        }
    }

    protected function updateTest($key, $postType)
    {
        if ($post = $this->makerData($postType)) {
            $model = app($postType->get('model'))->first(['id']);
            $response = $this->get('/admin-cp/posts/' . $model->id . '/edit');

            $response->assertStatus(200);

            $this->put('/admin-cp/'.$key.'/' . $model->id, $post);

            $model = app($postType->get('model'))
                ->where('id', '=', $model->id)
                ->first();

            $this->assertEquals($post['title'], $model->title);
        }
    }

    /**
     *
     * @param Collection $postType
     *
     * @return array|false
     */
    protected function makerData($postType)
    {
        try {
            $post = factory($postType->get('model'))->make();
            $post = $post->getAttributes();
        } catch (\Throwable $e) {
            echo "\n--- " . $e->getMessage();

            return false;
        }

        $taxonomies = HookAction::getTaxonomies($postType->get('key'));
        foreach ($taxonomies as $taxonomy) {
            $ids = app($taxonomy->get('model'))
                ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
                ->where('post_type', '=', $postType->get('key'))
                ->inRandomOrder()
                ->limit(5)
                ->pluck('id')
                ->toArray();

            $post[$taxonomy->get('taxonomy')] = $ids;
        }

        return $post;
    }
}
