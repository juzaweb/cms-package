<?php

namespace Juzaweb\Support\Macros;

use Illuminate\Support\Str;

class RouterMacros
{
    public function jwResource()
    {
        return function ($uri, $controller, $options = []) {
            if (! empty($options['name'])) {
                $routeName = $options['name'];
            } else {
                $routeName = str_replace(['{', '}'], '', $uri);
                $routeName = str_replace('/', '.', $routeName);
            }

            $routeName = 'admin.' . $routeName;

            $this->get($uri, $controller . '@index')->name($routeName .'.index');
            $this->get($uri . '/create', $controller . '@create')->name($routeName . '.create');
            $this->get($uri . '/{id}/edit', $controller . '@edit')->name($routeName . '.edit')->where('id', '[0-9]+');
            $this->post($uri, $controller . '@store')->name($routeName . '.store');
            $this->put($uri . '/{id}', $controller . '@update')->name($routeName . '.update');
        };
    }

    public function postTypeResource()
    {
        return function ($uri, $controller, $options = []) {
            $singular = Str::singular($uri);
            $this->jwResource($uri, $controller, $options);

            $this->jwResource($singular . '/comments', '\Juzaweb\Http\Controllers\Backend\CommentController', [
                'name' => $singular . '.comment',
            ]);

            $this->get($singular . '/{taxonomy}/component-item', '\Juzaweb\Http\Controllers\Backend\TaxonomyController@getTagComponent');

            $this->jwResource($singular . '/{taxonomy}', '\Juzaweb\Http\Controllers\Backend\TaxonomyController', [
                'name' => $singular . '.taxonomy',
            ]);
        };
    }
}
