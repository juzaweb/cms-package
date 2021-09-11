<?php

namespace Juzaweb\Http\Controllers\Frontend;

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

        return $this->handlePage($page);
    }

    protected function getPageSlug($slug)
    {
        return apply_filters('theme.page_slug', $slug[0], $slug);
    }

    protected function handlePage(Page $page, array $slugs = [])
    {
        /**
         * @var Config $theme
         */
        $theme = $this->getThemeInfo();
        $view = $this->getViewPage($page, $theme);

        $params = [
            'page' => $page,
            'title' => $page->name,
            'theme' => $theme,
        ];

        return apply_filters(
            'theme.page.handle',
            view($view, $params),
            $page,
            $slugs,
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
        $view = 'theme::page.index';
        if (!empty($page->template)) {
            $templates = $themeInfo->get('templates');
            $templateView = $templates[$page->template]['view'] ?? null;
            $templateView = 'theme::' . $templateView;

            if (view()->exists($templateView)) {
                $view = $templateView;
            }
        }

        return $view;
    }
}
