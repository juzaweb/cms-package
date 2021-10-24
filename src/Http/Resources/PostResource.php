<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->getContent(),
            'thumbnail' => $this->getThumbnail(),
            'url' => $this->getLink(),
            'views' => $this->getViews(),
            'status' => $this->status,
            'created_at' => jw_date_format($this->created_at),
            'updated_at' => jw_date_format($this->updated_at),
        ];
    }
}