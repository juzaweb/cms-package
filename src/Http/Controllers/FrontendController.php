<?php

namespace Juzaweb\Http\Controllers;

use Juzaweb\Abstracts\Action;
use Juzaweb\Facades\HookAction;
use Juzaweb\Traits\ResponseMessage;

class FrontendController extends Controller
{
    use ResponseMessage;

    public function callAction($method, $parameters)
    {
        /**
         * Action after call action frontend
         * Add action to this hook add_action('frontend.call_action', $callback)
         */
        do_action(Action::FRONTEND_CALL_ACTION, $method, $parameters);

        do_action(Action::WIDGETS_INIT);

        return parent::callAction($method, $parameters);
    }

    protected function getPermalinks($base = null)
    {
        if ($base) {
            return collect(HookAction::getPermalinks())
                ->where('base', $base)
                ->first();
        }

        return collect(HookAction::getPermalinks());
    }
}
