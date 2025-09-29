<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CustomTemplate\Transformers\CustomTemplateResource;
use Modules\Service\Transformers\SystemServiceResource;

class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {



        return [



            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'history_data' => json_decode($this->history_data),
            'word_count' => $this->word_count,
            'image_count' => $this->image_count,
            'template_id' => $this->templatedata ? new CustomTemplateResource($this->templatedata) : null,
            'histroy_image' => $this->historyimage
                                ? $this->historyimage->filter(function ($item) {
                                    return !is_null($item->image_url);
                                })->pluck('image_url')->toArray()
                                : [],
            'system_service' => new SystemServiceResource($this->SystemService),
            'created_at' => $this->created_at->setTimezone(setting('default_time_zone') ?? 'UTC')->format('Y-m-d H:i:s'),
            
        ];
    }
}
