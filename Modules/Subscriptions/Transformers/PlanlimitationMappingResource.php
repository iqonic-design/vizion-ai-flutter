<?php

namespace Modules\Subscriptions\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanlimitationMappingResource extends JsonResource
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
            'planlimitation_id'=>$this->planlimitation_id,
            'limitation_title'=>optional($this->limitation_data)->name,
            'limit_type'=>optional($this->limitation_data)->limit_type,
            'type'=>optional($this->limitation_data)->type,
            'limit' => $this->limit,
            'key'=>optional($this->limitation_data)->key,
            'status' => optional($this->limitation_data)->status,

        ];
    }
}