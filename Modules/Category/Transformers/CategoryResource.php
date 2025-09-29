<?php

namespace Modules\Category\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Service\Transformers\SystemServiceResource;
use Modules\CustomTemplate\Transformers\CustomTemplateResource;


class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'system_service' => $this->type,
            'status' => $this->status,
            'category_image' => $this->media->pluck('original_url')->first(),
            'custom_template'=>CustomTemplateResource::collection($this->customTemplate),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
