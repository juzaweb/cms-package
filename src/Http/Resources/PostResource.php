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
        $taxonomies = [];
        if ($this->taxonomies) {
            $taxonomies = TaxonomyResource::collection($this->taxonomies)
                ->toArray($request);
        }

        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'description' => $this->description,
            'content' => $this->getContent(),
            'thumbnail' => $this->getThumbnail(),
            'url' => $this->getLink(),
            'views' => $this->getViews(),
            'type' => $this->type,
            'status' => $this->status,
            'created_by' => $this->getCreatedByName(),
            'created_at' => jw_date_format($this->created_at),
            'updated_at' => jw_date_format($this->updated_at),
            'taxonomies' => $taxonomies
        ];
    }
}