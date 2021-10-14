<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Controllers\FrontendController;
use Juzaweb\Models\Page;
use Noodlehaus\Config;

class PageController extends FrontendController
{
    public function index(...$slug)
    {
        $pageSlug = $this->getPageSlug($slug);
        $page = Page::findBySlugOrFail($pageSlug);

        return $this->handlePage($page, $slug);
    }

    public function detail($id)
    {
        $page = Page::find($id);
        if (empty($page)) {
            return abort(404);
        }

        return $this->handlePage($page);
    }

    protected function getPageSlug($slug)
    {
        return apply_filters('theme.page_slug', $slug[0], $slug);
    }

    protected function handlePage(Page $page, array $slug = [])
    {
        /**
         * @var Config $theme
         */
        $theme = jw_theme_info();
        $view = $this->getViewPage($page, $theme);

        if (is_home()) {
            $config = get_configs(['title', 'description']);

            $params = [
                'post' => $page,
                'title' => $config['title'],
                'description' => $config['description'],
                'theme' => $theme,
                'slug' => $slug,
            ];
        } else {
            $params = [
                'post' => $page,
                'title' => $page->title,
                'description' => $page->description,
                'theme' => $theme,
                'slug' => $slug,
            ];
        }

        return apply_filters(
            'theme.page.handle',
            view($view, $params),
            $page,
            $slug,
            $params
        );
    }

    /**
     * @param Page $page
     * @param Config $themeInfo
     *
     * @return string
     */
    protected function getViewPage(Page $page, $themeInfo)
    {
        if (! empty($page->template)) {
            $templates = HookAction::getThemeTemplates($page->template);
            $templateView = $templates['view'] ?? null;
            $templateView = 'theme::' . $templateView;

            if (view()->exists($templateView)) {
                $view = $templateView;
            }
        }

        if (empty($view)) {
            $template = get_name_template_part('page', 'single');
            $view = 'theme::template-parts.' . $template;

            if (! view()->exists($view)) {
                $view = 'theme::template-parts.single';
            }
        }

        return $view;
    }
}
